<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\VehicleImportService;
use Illuminate\Console\Command;
use Throwable;

final class RebuildVehicleInventoryCommand extends Command
{
    protected $signature = 'inventory:rebuild {--source= : Directory containing one subdirectory per vehicle} {--dry-run : Validate and report without changes} {--force : Skip confirmation}';

    protected $description = 'Replace vehicle inventory from local vehicle directories.';

    public function handle(VehicleImportService $importer): int
    {
        $source = (string) ($this->option('source') ?: config('inventory.import_source'));
        if ($source === '') {
            $this->error('Pass --source or configure VEHICLE_IMPORT_SOURCE.');

            return self::FAILURE;
        }
        $this->info('Scanning source directory...');
        try {
            $manifest = $importer->inspect($source);
        } catch (Throwable $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }

        $this->newLine();
        $this->info(sprintf('Found %d vehicle directories.', count($manifest['vehicles'])));
        foreach ($manifest['vehicles'] as $index => $vehicle) {
            $this->line(sprintf('[%d/%d] %s | Price: $%s | Images: %d | description: %s | info: %s',
                $index + 1, count($manifest['vehicles']), $vehicle['title'], number_format($vehicle['price']), count($vehicle['images']),
                $vehicle['has_description'] ? 'yes' : 'no', $vehicle['has_info'] ? 'yes' : 'no'));
        }
        foreach ($manifest['warnings'] as $warning) {
            $this->warn('WARNING: '.$warning);
        }

        try {
            $preparedImageCount = $importer->preparedImageCount($manifest);
        } catch (Throwable $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }

        if ((bool) $this->option('dry-run')) {
            $this->newLine();
            $this->info(sprintf('Dry run complete: %d vehicles, %d prepared images, %d warning(s). No changes made.', count($manifest['vehicles']), $preparedImageCount, count($manifest['warnings'])));

            return self::SUCCESS;
        }
        if (! (bool) $this->option('force') && ! $this->confirm('This operation will delete the current vehicle inventory. Continue?', false)) {
            $this->warn('Inventory rebuild cancelled.');

            return self::FAILURE;
        }

        try {
            $result = $importer->rebuildDatabase($manifest);
        } catch (Throwable $exception) {
            $this->error('Inventory rebuild failed: '.$exception->getMessage());

            return self::FAILURE;
        }

        $this->newLine();
        $this->info('Inventory rebuild completed.');
        $this->table(['Metric', 'Count'], [['Vehicles imported', $result['vehicles']], ['Images linked', $result['images']],
            ['Makes created', $result['makes']], ['Models created', $result['models']], ['Warnings', count($result['warnings'])], ['Errors', 0]]);

        return self::SUCCESS;
    }
}
