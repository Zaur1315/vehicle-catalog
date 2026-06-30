<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Vehicle;
use App\Models\VehicleImage;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use RuntimeException;

final class ImportRealVehicleInventoryCommand extends Command
{
    protected $signature = 'app:vehicles:import-real-inventory
        {source : Path to folder containing *.txt files and image folders}
        {--clean : Delete existing vehicles, vehicle images, and processed storage/app/public/vehicles files before import}
        {--default-price=0 : Price to use when txt files do not contain price}
        {--quality=86 : WebP output quality}
        {--skip=* : Numeric prefixes to skip, for example --skip=7}
        {--allow-mismatch : Import even if txt filename slug and vehicle title do not match}';

    protected $description = 'Import real vehicle inventory from markdown txt descriptions and local image folders.';

    private ImageManager $imageManager;

    public function __construct()
    {
        parent::__construct();

        $this->imageManager = ImageManager::usingDriver(Driver::class);
    }

    public function handle(): int
    {
        $source = rtrim((string)$this->argument('source'), DIRECTORY_SEPARATOR);

        if (!File::isDirectory($source)) {
            $this->error(sprintf('Source directory does not exist: %s', $source));

            return self::FAILURE;
        }

        if ((bool)$this->option('clean')) {
            $this->cleanInventory();
        }

        $txtFiles = collect(File::files($source))
            ->filter(static fn($file) => preg_match('/^\d+_.+\.txt$/', $file->getFilename()) === 1)
            ->sortBy(static fn($file) => (int)Str::before($file->getFilename(), '_'))
            ->values();

        if ($txtFiles->isEmpty()) {
            $this->warn('No vehicle txt files found.');

            return self::SUCCESS;
        }

        $skip = collect($this->option('skip'))
            ->map(static fn($value) => (string)$value)
            ->filter()
            ->values()
            ->all();

        $imported = 0;

        foreach ($txtFiles as $txtFile) {
            $prefix = Str::before($txtFile->getFilename(), '_');

            if (in_array((string)$prefix, $skip, true)) {
                $this->warn(sprintf('Skipped vehicle prefix #%s by option.', $prefix));

                continue;
            }

            $vehicle = $this->parseVehicleFile($txtFile->getPathname());
            $fileSlug = Str::beforeLast(Str::after($txtFile->getFilename(), $prefix . '_'), '.txt');
            $titleSlug = Str::slug($vehicle['title']);

            if (!(bool)$this->option('allow-mismatch') && $fileSlug !== $titleSlug) {
                $this->error(sprintf(
                    'Mismatch in %s: filename slug is "%s", but title slug is "%s". Fix the txt file or run with --skip=%s.',
                    $txtFile->getFilename(),
                    $fileSlug,
                    $titleSlug,
                    $prefix,
                ));

                return self::FAILURE;
            }

            $imageDirectory = $this->findImageDirectory($source, (string)$prefix);

            if ($imageDirectory === null) {
                $this->error(sprintf('Image folder not found for prefix #%s.', $prefix));

                return self::FAILURE;
            }

            $stockNumber = 'A20' . str_pad((string)$prefix, 2, '0', STR_PAD_LEFT);
            $slug = Str::slug($vehicle['title'] . '-' . $stockNumber);
            $quality = (int)$this->option('quality');
            $defaultPrice = (int)$this->option('default-price');

            $make = VehicleMake::query()->updateOrCreate(
                ['name' => $vehicle['make']],
                ['slug' => Str::slug($vehicle['make'])],
            );

            $model = VehicleModel::query()->updateOrCreate(
                [
                    'vehicle_make_id' => $make->id,
                    'name' => $vehicle['model'],
                ],
                ['slug' => Str::slug($vehicle['model'])],
            );

            $mainImagePath = sprintf('vehicles/%s/large/main.webp', $slug);

            /** @var Vehicle $vehicleModel */
            $vehicleModel = Vehicle::query()->updateOrCreate(
                ['stock_number' => $stockNumber],
                [
                    'vehicle_make_id' => $make->id,
                    'vehicle_model_id' => $model->id,
                    'name' => $vehicle['title'],
                    'slug' => $slug,
                    'vin' => $this->normalizeVin($vehicle['vin']),
                    'year' => $vehicle['year'],
                    'price' => $defaultPrice,
                    'price_on_request' => $defaultPrice <= 0,
                    'mileage' => $vehicle['mileage'],
                    'condition' => Vehicle::CONDITION_USED,
                    'body_type' => $this->normalizeBodyType($vehicle['body_type']),
                    'transmission' => $this->normalizeTransmission($vehicle['transmission']),
                    'drivetrain' => $this->normalizeDrivetrain($vehicle['drivetrain']),
                    'engine' => $vehicle['engine'],
                    'fuel_type' => $this->normalizeFuelType($vehicle['engine']),
                    'exterior_color' => $vehicle['exterior_color'],
                    'interior_color' => $vehicle['interior_color'],
                    'short_description' => Str::limit($vehicle['short_description'], 240),
                    'description' => $vehicle['description'],
                    'features' => array_map(
                        static fn(string $label): array => ['label' => $label],
                        $vehicle['features'],
                    ),
                    'main_image' => $mainImagePath,
                    'status' => Vehicle::STATUS_AVAILABLE,
                    'is_featured' => true,
                    'is_active' => true,
                    'published_at' => now(),
                    'seo_title' => $vehicle['title'] . ' for Sale in Meriden, CT',
                    'seo_description' => sprintf(
                        '%s available from Marick Auto Sales in Meriden, CT. View mileage, photos, delivery, warranty, finance, and trade-in details.',
                        $vehicle['title'],
                    ),
                ],
            );

            $this->syncImages($vehicleModel, $slug, $vehicle['title'], $imageDirectory, $quality);

            $imported++;
            $this->info(sprintf('Imported %s (%s)', $vehicle['title'], $stockNumber));
        }

        $this->info(sprintf('Done. Vehicles imported: %d', $imported));

        return self::SUCCESS;
    }

    private function cleanInventory(): void
    {
        VehicleImage::query()->delete();
        Vehicle::query()->delete();
        Storage::disk('public')->deleteDirectory('vehicles');

        $this->warn('Existing vehicles, vehicle images, and processed vehicle files were deleted.');
    }

    private function parseVehicleFile(string $path): array
    {
        $text = File::get($path);
        $title = $this->extractTitle($text);
        $overview = $this->extractSection($text, 'Overview');

        return [
            'title' => $title,
            'year' => (int)Str::before($title, ' '),
            'make' => $this->requiredField($text, 'Make'),
            'model' => $this->requiredField($text, 'Model'),
            'engine' => $this->requiredField($text, 'Engine'),
            'drivetrain' => $this->requiredField($text, 'Drivetrain'),
            'mileage' => (int)preg_replace('/\D+/', '', $this->requiredField($text, 'Mileage')),
            'transmission' => $this->requiredField($text, 'Transmission'),
            'vin' => $this->requiredField($text, 'VIN'),
            'body_type' => $this->requiredField($text, 'Body Style'),
            'exterior_color' => $this->requiredField($text, 'Exterior Color'),
            'interior_color' => $this->requiredField($text, 'Interior Color'),
            'short_description' => $this->firstParagraph($overview),
            'description' => (string)Str::markdown($this->stripMetadataBlock($text)),
            'features' => $this->extractFeatures($text),
        ];
    }

    private function extractTitle(string $text): string
    {
        if (preg_match('/^\*\*(.+?)\*\*\s*$/m', $text, $match) !== 1) {
            throw new RuntimeException('Vehicle title not found.');
        }

        return trim($match[1]);
    }

    private function requiredField(string $text, string $field): string
    {
        $pattern = sprintf('/^\*\*%s:\*\*\s*(.+)$/mu', preg_quote($field, '/'));

        if (preg_match($pattern, $text, $match) !== 1) {
            throw new RuntimeException(sprintf('Required field "%s" not found.', $field));
        }

        return trim($match[1]);
    }

    private function stripMetadataBlock(string $text): string
    {
        $text = preg_replace('/^\*\*(Make|Model|Engine|Drivetrain|Mileage|Transmission|VIN|Body Style|Title Status|Exterior Color|Interior Color|Seller Type):\*\*.*\R?/mu', '', $text) ?? $text;

        return trim($text);
    }

    private function extractSection(string $text, string $section): string
    {
        $pattern = sprintf('/^## %s\s*(.+?)(?=^## |\z)/msu', preg_quote($section, '/'));

        if (preg_match($pattern, $text, $match) !== 1) {
            return '';
        }

        return trim($match[1]);
    }

    private function firstParagraph(string $markdown): string
    {
        $paragraphs = preg_split('/\R{2,}/', trim($markdown)) ?: [];
        $first = trim((string)($paragraphs[0] ?? ''));

        return $this->stripMarkdown($first);
    }

    private function extractFeatures(string $text): array
    {
        $sections = [
            'Factory Equipment',
            'Harley-Davidson / Tuscany Upgrades',
            'Modifications',
        ];

        $features = [];

        foreach ($sections as $section) {
            $content = $this->extractSection($text, $section);

            if ($content === '') {
                continue;
            }

            if (preg_match_all('/^\s*\*\s+(.+)$/mu', $content, $matches) !== 1) {
                continue;
            }

            foreach ($matches[1] as $feature) {
                $features[] = $this->stripMarkdown($feature);
            }
        }

        return collect($features)
            ->filter()
            ->unique()
            ->take(24)
            ->values()
            ->all();
    }

    private function stripMarkdown(string $value): string
    {
        $value = preg_replace('/\*\*(.+?)\*\*/', '$1', $value) ?? $value;
        $value = preg_replace('/`(.+?)`/', '$1', $value) ?? $value;
        $value = preg_replace('/\[(.+?)\]\(.+?\)/', '$1', $value) ?? $value;

        return trim($value);
    }

    private function findImageDirectory(string $source, string $prefix): ?string
    {
        foreach (File::directories($source) as $directory) {
            $basename = basename($directory);

            if (!Str::startsWith($basename, $prefix . '_')) {
                continue;
            }

            $imageDirectory = $directory . DIRECTORY_SEPARATOR . 'img';

            if (File::isDirectory($imageDirectory)) {
                return $imageDirectory;
            }
        }

        return null;
    }

    private function syncImages(Vehicle $vehicle, string $slug, string $name, string $imageDirectory, int $quality): void
    {
        $vehicle->images()->delete();

        $sourceImages = collect(File::files($imageDirectory))
            ->filter(static fn($file) => in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp'], true))
            ->sortBy(static fn($file) => $file->getFilename())
            ->values();

        if ($sourceImages->isEmpty()) {
            throw new RuntimeException(sprintf('No images found for %s.', $name));
        }

        foreach ($sourceImages as $index => $sourceImage) {
            $basename = $index === 0 ? 'main' : str_pad((string)$index, 2, '0', STR_PAD_LEFT);
            $large = sprintf('vehicles/%s/large/%s.webp', $slug, $basename);
            $medium = sprintf('vehicles/%s/medium/%s.webp', $slug, $basename);
            $thumb = sprintf('vehicles/%s/thumb/%s.webp', $slug, $basename);

            $this->generateWebp($sourceImage->getPathname(), $large, 1920, 1280, $quality, 'contain');
            $this->generateWebp($sourceImage->getPathname(), $medium, 960, 640, $quality, 'contain');
            $this->generateWebp($sourceImage->getPathname(), $thumb, 480, 320, $quality, 'cover');

            VehicleImage::query()->create([
                'vehicle_id' => $vehicle->id,
                'path' => $large,
                'alt' => $index === 0 ? $name . ' main photo' : sprintf('%s photo %d', $name, $index + 1),
                'sort_order' => $index,
                'is_main' => $index === 0,
            ]);
        }
    }

    private function generateWebp(
        string $sourcePath,
        string $targetRelativePath,
        int    $width,
        int    $height,
        int    $quality,
        string $mode,
    ): void
    {
        $targetAbsolutePath = Storage::disk('public')->path($targetRelativePath);

        File::ensureDirectoryExists(dirname($targetAbsolutePath));

        $image = $this->imageManager->decodePath($sourcePath);

        $image = match ($mode) {
            'cover' => $image->cover($width, $height),
            'contain' => $image->scaleDown(width: $width, height: $height),
            default => throw new RuntimeException(sprintf('Unsupported image mode: %s', $mode)),
        };

        $image->save($targetAbsolutePath, quality: $quality);
    }

    private function normalizeBodyType(string $value): string
    {
        $value = Str::lower($value);

        return match (true) {
            str_contains($value, 'truck') => 'truck',
            str_contains($value, 'coupe') => 'coupe',
            str_contains($value, 'suv'), str_contains($value, 'crossover') => 'suv',
            default => 'suv',
        };
    }

    private function normalizeTransmission(string $value): string
    {
        $value = Str::lower($value);

        return str_contains($value, 'manual') ? 'manual' : 'automatic';
    }

    private function normalizeDrivetrain(string $value): string
    {
        $value = Str::lower($value);

        return match (true) {
            str_contains($value, '4wd') => '4wd',
            str_contains($value, 'awd') => 'awd',
            str_contains($value, 'rwd') => 'rwd',
            str_contains($value, 'fwd') => 'fwd',
            default => 'awd',
        };
    }

    private function normalizeFuelType(string $engine): string
    {
        $engine = Str::lower($engine);

        return match (true) {
            str_contains($engine, 'diesel'), str_contains($engine, 'turbodiesel') => 'diesel',
            str_contains($engine, 'hybrid') => 'hybrid',
            str_contains($engine, 'electric') => 'electric',
            default => 'gasoline',
        };
    }

    private function normalizeVin(string $vin): string
    {
        return strtr(Str::upper($vin), [
            'А' => 'A',
            'В' => 'B',
            'Е' => 'E',
            'К' => 'K',
            'М' => 'M',
            'Н' => 'H',
            'О' => 'O',
            'Р' => 'P',
            'С' => 'C',
            'Т' => 'T',
            'Х' => 'X',
            'У' => 'Y',
        ]);
    }
}
