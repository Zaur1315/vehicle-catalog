<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Vehicle;
use App\Models\VehicleImage;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

final class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = [
            [
                'make' => 'Toyota',
                'model' => 'Camry',
                'year' => 2021,
                'trim' => 'SE',
                'price' => 23900,
                'mileage' => 41200,
                'body_type' => 'sedan',
                'transmission' => 'automatic',
                'drivetrain' => 'fwd',
                'engine' => '2.5L 4-Cylinder',
                'fuel_type' => 'gasoline',
                'exterior_color' => 'White',
                'interior_color' => 'Black',
                'vin' => '4T1G11AK1MU000001',
                'stock_number' => 'A1001',
                'image_count' => 4,
                'features' => [
                    'Backup camera',
                    'Bluetooth',
                    'Lane assist',
                    'Apple CarPlay',
                    'Sport seats',
                    'Automatic climate control',
                ],
            ],
            [
                'make' => 'Ford',
                'model' => 'F-150',
                'year' => 2020,
                'trim' => 'XLT',
                'price' => 32900,
                'mileage' => 56800,
                'body_type' => 'truck',
                'transmission' => 'automatic',
                'drivetrain' => '4wd',
                'engine' => '3.5L V6 EcoBoost',
                'fuel_type' => 'gasoline',
                'exterior_color' => 'Blue',
                'interior_color' => 'Gray',
                'vin' => '1FTEW1E45LFA00002',
                'stock_number' => 'A1002',
                'image_count' => 4,
                'features' => [
                    'Tow package',
                    'Backup camera',
                    'Bluetooth',
                    'Running boards',
                    'FX4 package',
                    'Power driver seat',
                ],
            ],
            [
                'make' => 'BMW',
                'model' => 'X5',
                'year' => 2022,
                'trim' => 'xDrive40i',
                'price' => 52900,
                'mileage' => 28700,
                'body_type' => 'suv',
                'transmission' => 'automatic',
                'drivetrain' => 'awd',
                'engine' => '3.0L Turbo I6',
                'fuel_type' => 'gasoline',
                'exterior_color' => 'Black',
                'interior_color' => 'Cognac',
                'vin' => '5UXCR6C05N9000003',
                'stock_number' => 'A1003',
                'image_count' => 3,
                'features' => [
                    'Navigation',
                    'Panoramic roof',
                    'Heated seats',
                    'Leather interior',
                    'Premium package',
                    'Parking sensors',
                ],
            ],
            [
                'make' => 'Mercedes-Benz',
                'model' => 'C-Class',
                'year' => 2021,
                'trim' => 'C 300',
                'price' => 34900,
                'mileage' => 33400,
                'body_type' => 'sedan',
                'transmission' => 'automatic',
                'drivetrain' => 'rwd',
                'engine' => '2.0L Turbo 4-Cylinder',
                'fuel_type' => 'gasoline',
                'exterior_color' => 'Silver',
                'interior_color' => 'Black',
                'vin' => 'W1KWF8DB1MR000004',
                'stock_number' => 'A1004',
                'image_count' => 3,
                'features' => [
                    'Blind spot monitor',
                    'Sunroof',
                    'Bluetooth',
                    'Premium audio',
                    'Power seats',
                    'Keyless start',
                ],
            ],
            [
                'make' => 'Chevrolet',
                'model' => 'Tahoe',
                'year' => 2019,
                'trim' => 'LT',
                'price' => 38900,
                'mileage' => 64200,
                'body_type' => 'suv',
                'transmission' => 'automatic',
                'drivetrain' => '4wd',
                'engine' => '5.3L V8',
                'fuel_type' => 'gasoline',
                'exterior_color' => 'Gray',
                'interior_color' => 'Black',
                'vin' => '1GNSKBKC9KR000005',
                'stock_number' => 'A1005',
                'image_count' => 6,
                'features' => [
                    'Third row seating',
                    'Tow package',
                    'Remote start',
                    'Backup camera',
                    'Leather seats',
                    'Rear climate control',
                ],
            ],
        ];

        foreach ($vehicles as $data) {
            $make = VehicleMake::query()
                ->where('name', $data['make'])
                ->first();

            if ($make === null) {
                continue;
            }

            $model = VehicleModel::query()
                ->where('vehicle_make_id', $make->id)
                ->where('name', $data['model'])
                ->first();

            if ($model === null) {
                continue;
            }

            $name = sprintf(
                '%d %s %s %s',
                $data['year'],
                $data['make'],
                $data['model'],
                $data['trim'],
            );

            $slug = Str::slug($name . '-' . $data['stock_number']);
            $mainImagePath = $this->imagePath($slug, 'large', 'main');

            /** @var Vehicle $vehicle */
            $vehicle = Vehicle::query()->updateOrCreate(
                ['stock_number' => $data['stock_number']],
                [
                    'vehicle_make_id' => $make->id,
                    'vehicle_model_id' => $model->id,
                    'name' => $name,
                    'slug' => $slug,
                    'vin' => $data['vin'],
                    'year' => $data['year'],
                    'price' => $data['price'],
                    'price_on_request' => false,
                    'mileage' => $data['mileage'],
                    'condition' => Vehicle::CONDITION_USED,
                    'body_type' => $data['body_type'],
                    'transmission' => $data['transmission'],
                    'drivetrain' => $data['drivetrain'],
                    'engine' => $data['engine'],
                    'fuel_type' => $data['fuel_type'],
                    'exterior_color' => $data['exterior_color'],
                    'interior_color' => $data['interior_color'],
                    'short_description' => sprintf(
                        'Clean used %s with verified inventory details and dealer inspection.',
                        $name,
                    ),
                    'description' => sprintf(
                        '<p>This %s has been prepared for sale and is available from Marick Auto Sales in Meriden, CT.</p><p>Contact our sales team for current availability, pricing confirmation, delivery options, warranty details, finance questions, and trade-in review.</p>',
                        e($name),
                    ),
                    'features' => array_map(
                        static fn(string $label): array => ['label' => $label],
                        $data['features'],
                    ),
                    'main_image' => $mainImagePath,
                    'status' => Vehicle::STATUS_AVAILABLE,
                    'is_featured' => true,
                    'is_active' => true,
                    'published_at' => now(),
                    'seo_title' => $name . ' for Sale in Meriden, CT',
                    'seo_description' => $name . ' available from Marick Auto Sales in Meriden, CT. View price, mileage, photos, delivery, warranty, finance, and trade-in details.',
                ],
            );

            $this->syncVehicleImages(
                vehicle: $vehicle,
                slug: $slug,
                name: $name,
                imageCount: (int)$data['image_count'],
            );
        }
    }

    private function syncVehicleImages(Vehicle $vehicle, string $slug, string $name, int $imageCount): void
    {
        $vehicle->images()->delete();

        VehicleImage::query()->create([
            'vehicle_id' => $vehicle->id,
            'path' => $this->imagePath($slug, 'large', 'main'),
            'alt' => $name . ' main photo',
            'sort_order' => 0,
            'is_main' => true,
        ]);

        for ($index = 1; $index <= $imageCount; $index++) {
            VehicleImage::query()->create([
                'vehicle_id' => $vehicle->id,
                'path' => $this->imagePath($slug, 'large', str_pad((string)$index, 2, '0', STR_PAD_LEFT)),
                'alt' => sprintf('%s photo %d', $name, $index),
                'sort_order' => $index,
                'is_main' => false,
            ]);
        }
    }

    private function imagePath(string $slug, string $size, string $name): string
    {
        return sprintf('vehicles/%s/%s/%s.webp', $slug, $size, $name);
    }
}
