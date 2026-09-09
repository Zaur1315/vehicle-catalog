<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\Vehicle;

/** Suppress generic imported marketing copy without mutating inventory records. */
final class VehiclePublicCopy
{
    public static function description(Vehicle $vehicle): string
    {
        if (self::isImportedTemplate($vehicle->description, $vehicle->name)) {
            return '';
        }

        return VehicleDescriptionSanitizer::sanitize($vehicle->description);
    }

    public static function summary(Vehicle $vehicle): ?string
    {
        return self::isImportedSummary($vehicle->short_description, $vehicle->name)
            ? null
            : $vehicle->short_description;
    }

    public static function seoTitle(Vehicle $vehicle): string
    {
        return sprintf('%s in %s, %s', $vehicle->name, config('site.city'), config('site.state'));
    }

    public static function seoDescription(Vehicle $vehicle): string
    {
        return sprintf('Explore %s at %s. View photos, specifications and availability, or contact our team in %s.',
            $vehicle->name, config('site.name'), config('site.city'));
    }

    private static function isImportedTemplate(?string $description, string $vehicleName): bool
    {
        if (! is_string($description)) {
            return false;
        }

        return preg_match(
            '/^<p>This '.preg_quote($vehicleName, '/').' has been prepared for sale and is available from .+<\/p><p>Contact our sales team for current availability, pricing confirmation, delivery options, warranty details, finance questions, and trade-in review\.<\/p>$/',
            $description,
        ) === 1;
    }

    private static function isImportedSummary(?string $summary, string $vehicleName): bool
    {
        return $summary === sprintf('Clean used %s with verified inventory details and dealer inspection.', $vehicleName);
    }
}
