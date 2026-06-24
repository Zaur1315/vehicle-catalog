<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\VehicleMake;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

final class VehicleMakeSeeder extends Seeder
{
    public function run(): void
    {
        $makes = [
            'Toyota',
            'Honda',
            'Ford',
            'Chevrolet',
            'BMW',
            'Mercedes-Benz',
            'Nissan',
            'Hyundai',
            'Kia',
            'Jeep',
        ];

        foreach ($makes as $make) {
            VehicleMake::query()->updateOrCreate(
                ['slug' => Str::slug($make)],
                [
                    'name' => $make,
                    'description' => null,
                    'logo' => null,
                    'is_active' => true,
                ],
            );
        }
    }
}
