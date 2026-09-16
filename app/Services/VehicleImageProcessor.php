<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Filesystem\Filesystem;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\ImageManager;
use RuntimeException;
use Throwable;

final class VehicleImageProcessor
{
    private const SIZES = ['thumb' => 480, 'medium' => 1024, 'large' => 1920];

    private readonly ImageManager $images;

    public function __construct(private readonly Filesystem $files)
    {
        $driver = extension_loaded('imagick') ? ImagickDriver::class : GdDriver::class;
        $this->images = new ImageManager($driver);
    }

    /** @param list<string> $sourceImages @param callable(string): void $warn @return list<array{path: string, alt: string, sort_order: int, is_main: bool}> */
    public function process(array $sourceImages, string $stagingRoot, string $slug, string $vehicleName, int $quality, callable $warn): array
    {
        $processed = [];

        foreach ($sourceImages as $sourcePath) {
            try {
                $image = $this->images->decodePath($sourcePath)->orient();
                $number = count($processed) + 1;
                $filename = sprintf('%03d.webp', $number);

                foreach (self::SIZES as $directory => $width) {
                    $target = $stagingRoot."/{$slug}/{$directory}/{$filename}";
                    $this->files->ensureDirectoryExists(dirname($target));
                    (clone $image)->scaleDown(width: $width)->save($target, quality: $quality);
                }

                unset($image);
                $processed[] = [
                    'path' => "images/vehicles/{$slug}/large/{$filename}",
                    'alt' => sprintf('%s photo %d', $vehicleName, $number),
                    'sort_order' => $number - 1,
                    'is_main' => $number === 1,
                ];
            } catch (Throwable $exception) {
                $warn(sprintf('Unable to process %s: %s', $sourcePath, $exception->getMessage()));
            }
        }

        if ($processed === []) {
            throw new RuntimeException(sprintf('No valid images could be processed for %s.', $vehicleName));
        }

        return $processed;
    }
}
