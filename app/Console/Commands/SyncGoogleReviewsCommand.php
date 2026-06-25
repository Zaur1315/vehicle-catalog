<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\Google\GooglePlacesReviewSyncService;
use Illuminate\Console\Command;
use Throwable;

final class SyncGoogleReviewsCommand extends Command
{
    protected $signature = 'app:google-reviews:sync';

    protected $description = 'Sync Google Business reviews from Google Places API.';

    public function handle(GooglePlacesReviewSyncService $service): int
    {
        try {
            $count = $service->sync();
        } catch (Throwable $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }

        $this->info(sprintf('Google reviews synced: %d', $count));

        return self::SUCCESS;
    }
}
