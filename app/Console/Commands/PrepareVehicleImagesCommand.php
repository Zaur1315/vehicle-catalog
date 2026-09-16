<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\VehicleImportService;
use Illuminate\Console\Command;
use Throwable;

final class PrepareVehicleImagesCommand extends Command
{
    protected $signature = 'inventory:prepare-images
        {--source= : Directory containing one subdirectory per vehicle}
        {--dry-run : Validate and report without creating images}
        {--force : Replace public/images/vehicles without confirmation}';

    protected $description = 'Convert source vehicle images to Git-trackable WebP variants in public/images/vehicles.';

    public function handle(VehicleImportService $importer): int
    {
        $source = (string) ($this->option('source') ?: config('inventory.import_source'));
        if ($source === '') {
            $this->error('Pass --source or configure VEHICLE_IMPORT_SOURCE.');

            return self::FAILURE;
        }

        try {
            $manifest = $importer->inspect($source);
        } catch (Throwable $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }

        $this->info(sprintf('Found %d vehicles and %d source images.', count($manifest['vehicles']), $manifest['image_count']));
        foreach ($manifest['warnings'] as $warning) {
            $this->warn('WARNING: '.$warning);
        }

        if ((bool) $this->option('dry-run')) {
            $this->info('Dry run complete. No files were created or removed.');

            return self::SUCCESS;
        }

        if (! (bool) $this->option('force') && ! $this->confirm('Replace public/images/vehicles with newly converted images?', false)) {
            $this->warn('Image preparation cancelled.');

            return self::FAILURE;
        }

        try {
            $result = $importer->prepareImages(
                $manifest,
                fn (string $message) => $this->line($message.' — processing...'),
                fn (string $message) => $this->warn('WARNING: '.$message),
            );
        } catch (Throwable $exception) {
            $this->error('Image preparation failed: '.$exception->getMessage());

            return self::FAILURE;
        }

        $this->info(sprintf(
            'Image preparation complete: %d vehicles, %d images, %d WebP files, %d warning(s).',
            $result['vehicles'],
            $result['images'],
            $result['images'] * 3,
            count($result['warnings']),
        ));
        $this->line('Output: '.public_path('images/vehicles'));

        return self::SUCCESS;
    }
}
