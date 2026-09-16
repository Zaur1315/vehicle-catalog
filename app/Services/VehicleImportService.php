<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Vehicle;
use App\Models\VehicleImage;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

final class VehicleImportService
{
    private const IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp'];

    public function __construct(private readonly Filesystem $files, private readonly VehicleImageProcessor $imageProcessor) {}

    /** @return array{vehicles: list<array<string, mixed>>, unmatched_prices: list<string>, warnings: list<string>, image_count: int} */
    public function inspect(string $source, bool $requireSourceImages = true): array
    {
        $source = rtrim($source, DIRECTORY_SEPARATOR);
        if (! $this->files->isDirectory($source) || ! is_readable($source)) {
            throw new RuntimeException("Source directory is missing or unreadable: {$source}");
        }

        $prices = config('inventory.prices', []);
        $disclosures = config('inventory.disclosures', []);
        $vehicles = [];
        $warnings = [];
        $slugs = [];
        $directories = $this->files->directories($source);
        usort($directories, 'strnatcasecmp');

        foreach ($directories as $directory) {
            $directoryName = basename($directory);
            if (preg_match('/^(\d+)-(.*)$/u', $directoryName, $matches) !== 1) {
                $warnings[] = "Ignored directory with unsupported name: {$directoryName}";

                continue;
            }

            $sourceId = $matches[1];
            $folderTitle = $matches[2];
            $infoPath = $directory.'/info.txt';
            $descriptionPath = $directory.'/description.txt';
            $info = $this->parseInfo($this->readOptionalText($infoPath));
            $description = $this->readOptionalText($descriptionPath);
            $title = $info['Title'] ?? $folderTitle;

            if ($title === '' || ! isset($prices[$title])) {
                throw new RuntimeException("No exact price mapping exists for source vehicle: {$title}");
            }

            $year = $this->integer($info['Year'] ?? strtok($title, ' '));
            $make = $info['Make'] ?? null;
            $model = $info['Model'] ?? null;
            if ($year === null || $make === null || $make === '' || $model === null || $model === '') {
                throw new RuntimeException("Required Year/Make/Model data is missing for {$directoryName}");
            }

            $slug = Str::slug($title);
            if ($slug === '' || isset($slugs[$slug])) {
                throw new RuntimeException("Duplicate or invalid slug for {$title}: {$slug}");
            }
            $slugs[$slug] = true;

            $images = $this->imageFiles($directory);
            if ($requireSourceImages && $images === []) {
                throw new RuntimeException("No supported images found for {$directoryName}");
            }

            $fixedKeys = ['Title', 'Year', 'Make', 'Model', 'VIN', 'Mileage', 'Engine', 'Exterior Color', 'Interior Color'];
            $features = [];
            foreach ($info as $key => $value) {
                if (! in_array($key, $fixedKeys, true)) {
                    $features[] = ['label' => "{$key}: {$value}"];
                }
            }

            $disclosure = $disclosures[$title] ?? null;
            if (is_string($disclosure) && $disclosure !== '') {
                $separator = match (true) {
                    $description === '' => '',
                    str_ends_with($description, "\n") => "\n",
                    default => "\n\n",
                };
                $description .= $separator.$disclosure;
                array_unshift($features, ['label' => $disclosure]);
            }

            $vehicles[] = [
                'source_id' => $sourceId, 'title' => $title, 'slug' => $slug,
                'year' => $year, 'make' => $make, 'model' => $model,
                'vin' => $info['VIN'] ?? null, 'mileage' => $this->integer($info['Mileage'] ?? null),
                'transmission' => $this->transmission($info['Transmission'] ?? null),
                'engine' => $info['Engine'] ?? null, 'drivetrain' => $this->drivetrain($info['Drivetrain'] ?? null),
                'body_type' => $this->bodyType($info['Body Style'] ?? null),
                'fuel_type' => $this->fuelType($info['Engine'] ?? null),
                'exterior_color' => $info['Exterior Color'] ?? null,
                'interior_color' => $info['Interior Color'] ?? null,
                'description' => $description, 'features' => $features,
                'price' => $prices[$title], 'images' => $images,
                'has_info' => $this->files->isFile($infoPath),
                'has_description' => $this->files->isFile($descriptionPath),
            ];
        }

        if ($vehicles === []) {
            throw new RuntimeException("No vehicle directories found in {$source}");
        }

        $unmatchedPrices = array_values(array_diff(array_keys($prices), array_column($vehicles, 'title')));
        foreach ($unmatchedPrices as $title) {
            $warnings[] = "Price entry has no source directory: {$title}";
        }

        return ['vehicles' => $vehicles, 'unmatched_prices' => $unmatchedPrices, 'warnings' => $warnings,
            'image_count' => array_sum(array_map(static fn (array $vehicle): int => count($vehicle['images']), $vehicles))];
    }

    /** @param array{vehicles: list<array<string, mixed>>, unmatched_prices: list<string>, warnings: list<string>, image_count: int} $manifest @param callable(string): void $progress @param callable(string): void $warn @return array{vehicles: int, images: int, warnings: list<string>} */
    public function prepareImages(array $manifest, callable $progress, callable $warn): array
    {
        $imagesRoot = public_path('images');
        $target = $imagesRoot.'/vehicles';
        $token = Str::uuid()->toString();
        $staging = $imagesRoot.'/.vehicle-images-'.$token;
        $backup = $imagesRoot.'/.vehicle-images-backup-'.$token;
        $processedVehicles = [];
        $warnings = $manifest['warnings'];
        $this->files->ensureDirectoryExists($staging);

        try {
            foreach ($manifest['vehicles'] as $index => $vehicle) {
                $progress(sprintf('[%d/%d] %s', $index + 1, count($manifest['vehicles']), $vehicle['title']));
                $vehicle['processed_images'] = $this->imageProcessor->process(
                    $vehicle['images'], $staging, $vehicle['slug'], $vehicle['title'], (int) config('inventory.image_quality', 84),
                    function (string $message) use (&$warnings, $warn): void {
                        $warnings[] = $message;
                        $warn($message);
                    },
                );
                $processedVehicles[] = $vehicle;
            }

            if ($this->files->isDirectory($target)) {
                $this->files->moveDirectory($target, $backup);
            }
            if (! $this->files->moveDirectory($staging, $target)) {
                throw new RuntimeException('Unable to activate processed vehicle images.');
            }
            $this->files->deleteDirectory($backup);
        } catch (\Throwable $exception) {
            $this->files->deleteDirectory($staging);
            if ($this->files->isDirectory($backup)) {
                $this->files->deleteDirectory($target);
                $this->files->moveDirectory($backup, $target);
            }
            throw $exception;
        }

        return ['vehicles' => count($processedVehicles),
            'images' => array_sum(array_map(static fn (array $vehicle): int => count($vehicle['processed_images']), $processedVehicles)),
            'warnings' => $warnings];
    }

    /** @param array{vehicles: list<array<string, mixed>>, unmatched_prices: list<string>, warnings: list<string>, image_count: int} $manifest @return array{vehicles: int, images: int, makes: int, models: int, warnings: list<string>} */
    public function rebuildDatabase(array $manifest): array
    {
        $preparedVehicles = [];

        foreach ($manifest['vehicles'] as $vehicle) {
            $vehicle['processed_images'] = $this->preparedImages($vehicle['slug'], $vehicle['title']);
            $preparedVehicles[] = $vehicle;
        }

        DB::transaction(function () use ($preparedVehicles): void {
            VehicleImage::query()->delete();
            Vehicle::query()->delete();
            VehicleModel::query()->delete();
            VehicleMake::query()->delete();

            foreach ($preparedVehicles as $vehicle) {
                $make = VehicleMake::query()->firstOrCreate(['slug' => Str::slug($vehicle['make'])], ['name' => $vehicle['make'], 'is_active' => true]);
                $model = VehicleModel::query()->firstOrCreate(
                    ['vehicle_make_id' => $make->id, 'slug' => Str::slug($vehicle['model'])],
                    ['name' => $vehicle['model'], 'is_active' => true],
                );
                $record = Vehicle::query()->create([
                    'vehicle_make_id' => $make->id, 'vehicle_model_id' => $model->id,
                    'name' => $vehicle['title'], 'slug' => $vehicle['slug'], 'stock_number' => 'SRC-'.$vehicle['source_id'],
                    'vin' => $vehicle['vin'], 'year' => $vehicle['year'], 'price' => $vehicle['price'], 'price_on_request' => false,
                    'mileage' => $vehicle['mileage'], 'condition' => Vehicle::CONDITION_USED,
                    'body_type' => $vehicle['body_type'], 'transmission' => $vehicle['transmission'],
                    'drivetrain' => $vehicle['drivetrain'], 'engine' => $vehicle['engine'], 'fuel_type' => $vehicle['fuel_type'],
                    'exterior_color' => $vehicle['exterior_color'], 'interior_color' => $vehicle['interior_color'],
                    'short_description' => null, 'description' => $vehicle['description'], 'features' => $vehicle['features'],
                    'main_image' => $vehicle['processed_images'][0]['path'], 'status' => Vehicle::STATUS_AVAILABLE,
                    'is_featured' => true, 'is_active' => true, 'published_at' => now(),
                    'seo_title' => $vehicle['title'].' for Sale',
                    'seo_description' => $vehicle['title'].' available from '.config('site.name').'.',
                ]);
                $record->images()->createMany($vehicle['processed_images']);
            }
        });

        return [
            'vehicles' => count($preparedVehicles),
            'images' => array_sum(array_map(static fn (array $vehicle): int => count($vehicle['processed_images']), $preparedVehicles)),
            'makes' => VehicleMake::query()->count(),
            'models' => VehicleModel::query()->count(),
            'warnings' => $manifest['warnings'],
        ];
    }

    /** @param array{vehicles: list<array<string, mixed>>} $manifest */
    public function preparedImageCount(array $manifest): int
    {
        return array_sum(array_map(
            fn (array $vehicle): int => count($this->preparedImages($vehicle['slug'], $vehicle['title'])),
            $manifest['vehicles'],
        ));
    }

    /** @return list<array{path: string, alt: string, sort_order: int, is_main: bool}> */
    private function preparedImages(string $slug, string $vehicleName): array
    {
        $root = public_path("images/vehicles/{$slug}");
        $largeFiles = $this->files->glob($root.'/large/*.webp');
        sort($largeFiles, SORT_NATURAL);

        if ($largeFiles === []) {
            throw new RuntimeException("Prepared images are missing for {$vehicleName}. Run inventory:prepare-images first.");
        }

        $images = [];
        foreach ($largeFiles as $index => $largePath) {
            $filename = basename($largePath);
            foreach (['thumb', 'medium'] as $size) {
                if (! $this->files->isFile("{$root}/{$size}/{$filename}")) {
                    throw new RuntimeException("Prepared {$size} image is missing: {$root}/{$size}/{$filename}");
                }
            }
            $images[] = [
                'path' => "images/vehicles/{$slug}/large/{$filename}",
                'alt' => sprintf('%s photo %d', $vehicleName, $index + 1),
                'sort_order' => $index,
                'is_main' => $index === 0,
            ];
        }

        return $images;
    }

    private function readOptionalText(string $path): string
    {
        if (! $this->files->isFile($path)) {
            return '';
        }
        if (! is_readable($path)) {
            throw new RuntimeException("Unreadable text file: {$path}");
        }
        $contents = $this->files->get($path);
        if (! mb_check_encoding($contents, 'UTF-8')) {
            throw new RuntimeException("Text file is not valid UTF-8: {$path}");
        }

        return $contents;
    }

    /** @return array<string, string> */
    private function parseInfo(string $text): array
    {
        $info = [];
        foreach (preg_split('/\R/u', $text) ?: [] as $line) {
            if (preg_match('/^([^:]+):\s*(.*)$/u', $line, $matches) === 1) {
                $info[$matches[1]] = $matches[2];
            }
        }

        return $info;
    }

    /** @return list<string> */
    private function imageFiles(string $directory): array
    {
        $images = array_values(array_filter($this->files->files($directory),
            static fn (string $path): bool => in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), self::IMAGE_EXTENSIONS, true) && is_readable($path)));
        usort($images, static function (string $left, string $right): int {
            $leftName = pathinfo($left, PATHINFO_FILENAME);
            $rightName = pathinfo($right, PATHINFO_FILENAME);
            $leftNumeric = ctype_digit($leftName);
            $rightNumeric = ctype_digit($rightName);
            if ($leftNumeric !== $rightNumeric) {
                return $leftNumeric ? -1 : 1;
            }
            if ($leftNumeric) {
                return ((int) $leftName <=> (int) $rightName) ?: strnatcasecmp(basename($left), basename($right));
            }

            return strnatcasecmp(basename($left), basename($right));
        });

        return $images;
    }

    private function integer(?string $value): ?int
    {
        if ($value === null || preg_match('/\d[\d,]*/', $value, $match) !== 1) {
            return null;
        }

        return (int) str_replace(',', '', $match[0]);
    }

    private function bodyType(?string $value): ?string
    {
        $v = Str::lower((string) $value);

        return match (true) {
            str_contains($v, 'sedan') => 'sedan', str_contains($v, 'coupe') => 'coupe', str_contains($v, 'suv'), str_contains($v, 'crossover') => 'suv', str_contains($v, 'truck') => 'truck', str_contains($v, 'convertible') => 'convertible', $value === null || $value === '' => null, default => $value
        };
    }

    private function transmission(?string $value): ?string
    {
        $v = Str::lower((string) $value);

        return match (true) {
            str_contains($v, 'manual') => 'manual', str_contains($v, 'automatic') => 'automatic', str_contains($v, 'cvt') => 'cvt', $value === null || $value === '' => null, default => $value
        };
    }

    private function drivetrain(?string $value): ?string
    {
        $v = Str::lower((string) $value);

        return match (true) {
            str_contains($v, '4wd') => '4wd', str_contains($v, 'awd') => 'awd', str_contains($v, 'rear-wheel') => 'rwd', str_contains($v, 'front-wheel') => 'fwd', $value === null || $value === '' => null, default => $value
        };
    }

    private function fuelType(?string $engine): ?string
    {
        $v = Str::lower((string) $engine);

        return match (true) {
            str_contains($v, 'diesel') => 'diesel', str_contains($v, 'hybrid') => 'hybrid', str_contains($v, 'electric') => 'electric', $engine === null || $engine === '' => null, default => 'gasoline'
        };
    }
}
