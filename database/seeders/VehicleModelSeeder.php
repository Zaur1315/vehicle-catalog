<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

final class VehicleModelSeeder extends Seeder
{
    public function run(): void
    {
        $modelsByMake = [
            'Toyota' => ['Camry', 'Corolla', 'RAV4', 'Highlander', 'Tacoma'],
            'Honda' => ['Accord', 'Civic', 'CR-V', 'Pilot', 'Odyssey'],
            'Ford' => ['F-150', 'Explorer', 'Escape', 'Mustang', 'Bronco'],
            'Chevrolet' => ['Silverado', 'Tahoe', 'Malibu', 'Equinox', 'Suburban'],
            'BMW' => ['3 Series', '5 Series', 'X3', 'X5', 'X7'],
            'Mercedes-Benz' => ['C-Class', 'E-Class', 'GLC', 'GLE', 'S-Class'],
            'Nissan' => ['Altima', 'Sentra', 'Rogue', 'Pathfinder', 'Frontier'],
            'Hyundai' => ['Elantra', 'Sonata', 'Tucson', 'Santa Fe', 'Palisade'],
            'Kia' => ['Forte', 'K5', 'Sportage', 'Sorento', 'Telluride'],
            'Jeep' => ['Wrangler', 'Grand Cherokee', 'Cherokee', 'Compass', 'Gladiator'],
        ];

        foreach ($modelsByMake as $makeName => $modelNames) {
            $make = VehicleMake::query()
                ->where('name', $makeName)
                ->first();

            if ($make === null) {
                continue;
            }

            foreach ($modelNames as $index => $modelName) {
                VehicleModel::query()->updateOrCreate(
                    [
                        'vehicle_make_id' => $make->id,
                        'slug' => Str::slug($modelName),
                    ],
                    [
                        'name' => $modelName,
                        'description' => null,
                        'is_active' => true,
                        'sort_order' => $index + 1,
                    ],
                );
            }
        }
    }
}
