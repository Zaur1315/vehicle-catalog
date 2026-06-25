<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Vehicle;
use App\Models\VehicleImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Exceptions\DriverException;
use Intervention\Image\Exceptions\ImageDecoderException;
use Intervention\Image\Exceptions\InvalidArgumentException;
use Intervention\Image\ImageManager;
use SplFileInfo;

final class ProcessVehicleImagesCommand extends Command
{
    protected $signature = 'app:vehicles:process-images
        {source : Source directory with vehicle images}
        {--clean : Delete existing vehicle image files and database gallery rows before import}
        {--quality=82 : WebP quality from 1 to 100}';

    protected $description = 'Convert vehicle images to WebP, generate large/medium/thumb versions, and attach them to vehicles.';

    private const STOCK_ALIASES = [
        // Current seed photos.
        // Adjust these stock numbers if your VehicleSeeder uses different values.
        'camry' => 'A1001',
        'fx4' => 'A1002',
        'x5' => 'A1003',
        'c300' => 'A1004',
        'tahoe' => 'A1005',
    ];

    private ImageManager $imageManager;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct()
    {
        parent::__construct();

        $this->imageManager = ImageManager::usingDriver(Driver::class);
    }

    public function handle(): int
    {
        $source = rtrim((string)$this->argument('source'), DIRECTORY_SEPARATOR);
        $quality = max(1, min(100, (int)$this->option('quality')));

        if (!File::isDirectory($source)) {
            $this->error(sprintf('Source directory does not exist: %s', $source));

            return self::FAILURE;
        }

        $groups = $this->groupImages($source);

        if ($groups === []) {
            $this->warn('No images found.');

            return self::SUCCESS;
        }

        foreach ($groups as $groupKey => $items) {
            $stockNumber = $this->resolveStockNumber($groupKey);

            /** @var Vehicle|null $vehicle */
            $vehicle = Vehicle::query()
                ->where('stock_number', $stockNumber)
                ->first();

            if (!$vehicle) {
                $this->warn(sprintf(
                    'Vehicle not found for group "%s" with stock number "%s". Skipped.',
                    $groupKey,
                    $stockNumber,
                ));

                continue;
            }

            $this->processVehicle($vehicle, $items, $quality);
        }

        $this->info('Vehicle images processed successfully.');

        return self::SUCCESS;
    }

    /**
     * @return array<string, array<int, array{file: SplFileInfo, is_main: bool, sort_order: int}>>
     */
    private function groupImages(string $source): array
    {
        $groups = [];

        foreach (File::files($source) as $file) {
            if (!$this->isSupportedImage($file)) {
                continue;
            }

            $parsed = $this->parseFilename($file);

            if ($parsed === null) {
                $this->warn(sprintf('Cannot parse filename: %s', $file->getFilename()));

                continue;
            }

            $groups[$parsed['group']][] = [
                'file' => $file,
                'is_main' => $parsed['is_main'],
                'sort_order' => $parsed['sort_order'],
            ];
        }

        foreach ($groups as &$items) {
            usort($items, static function (array $a, array $b): int {
                if ($a['is_main'] !== $b['is_main']) {
                    return $a['is_main'] ? -1 : 1;
                }

                return $a['sort_order'] <=> $b['sort_order'];
            });
        }

        unset($items);

        return $groups;
    }

    private function isSupportedImage(SplFileInfo $file): bool
    {
        return in_array(
            strtolower($file->getExtension()),
            ['jpg', 'jpeg', 'png', 'webp'],
            true,
        );
    }

    /**
     * Supported current seed names:
     * camry-main.jpg, camry1.jpg, camry2.jpg
     * fx4-main.jpg, fx4-1.jpg
     * x5-main.jpg, x5-1.jpg
     * c300-main.jpg, c300-1.jpg
     * tahoe-main.jpg, tahoe-1.jpg
     *
     * Recommended future names:
     * A1001-main.jpg, A1001-1.jpg, A1001-2.jpg
     *
     * @return array{group: string, is_main: bool, sort_order: int}|null
     */
    private function parseFilename(SplFileInfo $file): ?array
    {
        $baseName = strtolower(pathinfo($file->getFilename(), PATHINFO_FILENAME));

        if (preg_match('/^(.+?)[-_]?main$/', $baseName, $matches) === 1) {
            return [
                'group' => $matches[1],
                'is_main' => true,
                'sort_order' => 0,
            ];
        }

        if (preg_match('/^(.+)[-_](\d+)$/', $baseName, $matches) === 1) {
            return [
                'group' => $matches[1],
                'is_main' => false,
                'sort_order' => (int)$matches[2],
            ];
        }

        if (preg_match('/^([a-z]+)(\d+)$/', $baseName, $matches) === 1) {
            return [
                'group' => $matches[1],
                'is_main' => false,
                'sort_order' => (int)$matches[2],
            ];
        }

        return null;
    }

    private function resolveStockNumber(string $groupKey): string
    {
        return self::STOCK_ALIASES[$groupKey] ?? strtoupper($groupKey);
    }

    /**
     * @param array<int, array{file: SplFileInfo, is_main: bool, sort_order: int}> $items
     */
    private function processVehicle(Vehicle $vehicle, array $items, int $quality): void
    {
        $baseDirectory = sprintf('vehicles/%s', $vehicle->slug);

        if ((bool)$this->option('clean')) {
            Storage::disk('public')->deleteDirectory($baseDirectory);

            $vehicle->images()->delete();
            $vehicle->update([
                'main_image' => null,
            ]);
        }

        $this->line(sprintf('Processing %s [%s]', $vehicle->name, $vehicle->stock_number));

        $mainImagePath = null;

        foreach ($items as $index => $item) {
            $isMain = $item['is_main'];
            $sortOrder = $isMain ? 0 : $item['sort_order'];

            $fileName = $isMain
                ? 'main'
                : str_pad((string)$sortOrder, 2, '0', STR_PAD_LEFT);

            $largePath = sprintf('%s/large/%s.webp', $baseDirectory, $fileName);
            $mediumPath = sprintf('%s/medium/%s.webp', $baseDirectory, $fileName);
            $thumbPath = sprintf('%s/thumb/%s.webp', $baseDirectory, $fileName);

            try {
                $this->generateWebp(
                    sourcePath: $item['file']->getPathname(),
                    targetRelativePath: $largePath,
                    width: 1920,
                    height: 1280,
                    quality: $quality,
                    mode: 'contain',
                );
            } catch (ImageDecoderException|DriverException|InvalidArgumentException $e) {
                Log::error($e->getMessage());
            }

            try {
                $this->generateWebp(
                    sourcePath: $item['file']->getPathname(),
                    targetRelativePath: $mediumPath,
                    width: 960,
                    height: 640,
                    quality: $quality,
                    mode: 'contain',
                );
            } catch (ImageDecoderException|DriverException|InvalidArgumentException $e) {
                Log::error($e->getMessage());
            }

            try {
                $this->generateWebp(
                    sourcePath: $item['file']->getPathname(),
                    targetRelativePath: $thumbPath,
                    width: 480,
                    height: 320,
                    quality: $quality,
                    mode: 'cover',
                );
            } catch (ImageDecoderException|DriverException|InvalidArgumentException $e) {
                Log::error($e->getMessage());
            }

            if ($isMain || $mainImagePath === null) {
                $mainImagePath = $largePath;
            }

            VehicleImage::query()->updateOrCreate(
                [
                    'vehicle_id' => $vehicle->id,
                    'path' => $largePath,
                ],
                [
                    'alt' => sprintf('%s photo %d', $vehicle->name, $index + 1),
                    'sort_order' => $sortOrder,
                    'is_main' => $isMain,
                ],
            );
        }

        if ($mainImagePath !== null) {
            $vehicle->update([
                'main_image' => $mainImagePath,
            ]);
        }
    }

    /**
     * @throws DriverException
     * @throws InvalidArgumentException
     * @throws ImageDecoderException
     */
    private function generateWebp(
        string $sourcePath,
        string $targetRelativePath,
        int $width,
        int $height,
        int $quality,
        string $mode,
    ): void {
        $targetAbsolutePath = Storage::disk('public')->path($targetRelativePath);

        File::ensureDirectoryExists(dirname($targetAbsolutePath));

        $image = $this->imageManager->decodePath($sourcePath);

        $image = match ($mode) {
            'cover' => $image->cover($width, $height),
            'contain' => $image->scaleDown(width: $width, height: $height),
            default => throw new \InvalidArgumentException(sprintf('Unsupported image mode: %s', $mode)),
        };

        $image->save($targetAbsolutePath, quality: $quality);
    }
}
