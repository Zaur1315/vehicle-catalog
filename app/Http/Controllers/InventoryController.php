<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class InventoryController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $filters = [
            'make' => $request->string('make')->toString(),
            'model' => $request->string('model')->toString(),
            'year_from' => $request->integer('year_from') ?: null,
            'year_to' => $request->integer('year_to') ?: null,
            'price_min' => $request->integer('price_min') ?: null,
            'price_max' => $request->integer('price_max') ?: null,
            'mileage_min' => $request->integer('mileage_min') ?: null,
            'mileage_max' => $request->integer('mileage_max') ?: null,
            'body_type' => $request->string('body_type')->toString(),
            'transmission' => $request->string('transmission')->toString(),
            'drivetrain' => $request->string('drivetrain')->toString(),
            'color' => $request->string('color')->toString(),
            'sort' => $request->string('sort')->toString() ?: 'newest',
        ];

        $vehicles = Vehicle::query()
            ->with(['make', 'vehicleModel'])
            ->where('is_active', true)
            ->where('status', Vehicle::STATUS_AVAILABLE)
            ->when($filters['make'] !== '', function ($query) use ($filters): void {
                $query->whereHas('make', static function ($makeQuery) use ($filters): void {
                    $makeQuery->where('slug', $filters['make']);
                });
            })
            ->when($filters['model'] !== '', function ($query) use ($filters): void {
                $query->whereHas('vehicleModel', static function ($modelQuery) use ($filters): void {
                    $modelQuery->where('slug', $filters['model']);
                });
            })
            ->when($filters['year_from'] !== null, static fn($query) => $query->where('year', '>=', $filters['year_from']))
            ->when($filters['year_to'] !== null, static fn($query) => $query->where('year', '<=', $filters['year_to']))
            ->when($filters['price_min'] !== null, static fn($query) => $query->where('price', '>=', $filters['price_min']))
            ->when($filters['price_max'] !== null, static fn($query) => $query->where('price', '<=', $filters['price_max']))
            ->when($filters['mileage_min'] !== null, static fn($query) => $query->where('mileage', '>=', $filters['mileage_min']))
            ->when($filters['mileage_max'] !== null, static fn($query) => $query->where('mileage', '<=', $filters['mileage_max']))
            ->when($filters['body_type'] !== '', static fn($query) => $query->where('body_type', $filters['body_type']))
            ->when($filters['transmission'] !== '', static fn($query) => $query->where('transmission', $filters['transmission']))
            ->when($filters['drivetrain'] !== '', static fn($query) => $query->where('drivetrain', $filters['drivetrain']))
            ->when($filters['color'] !== '', static fn($query) => $query->where('exterior_color', $filters['color']));

        match ($filters['sort']) {
            'price_asc' => $vehicles->orderBy('price'),
            'price_desc' => $vehicles->orderByDesc('price'),
            'year_desc' => $vehicles->orderByDesc('year'),
            'year_asc' => $vehicles->orderBy('year'),
            'mileage_asc' => $vehicles->orderBy('mileage'),
            'mileage_desc' => $vehicles->orderByDesc('mileage'),
            default => $vehicles->latest(),
        };

        $paginatedVehicles = $vehicles
            ->paginate(12)
            ->withQueryString()
            ->through(static fn(Vehicle $vehicle): array => [
                'id' => $vehicle->id,
                'name' => $vehicle->name,
                'slug' => $vehicle->slug,
                'year' => $vehicle->year,
                'price' => $vehicle->formatted_price,
                'mileage' => $vehicle->formatted_mileage,
                'image' => $vehicle->main_image_url,
                'make' => $vehicle->make?->name,
                'model' => $vehicle->vehicleModel?->name,
                'body_type' => $vehicle->body_type,
                'transmission' => $vehicle->transmission,
                'drivetrain' => $vehicle->drivetrain,
                'exterior_color' => $vehicle->exterior_color,
            ]);

        return Inertia::render('Inventory/Index', [
            'vehicles' => $paginatedVehicles,
            'filters' => $filters,
            'filterOptions' => [
                'makes' => VehicleMake::query()
                    ->where('is_active', true)
                    ->orderBy('name')
                    ->get(['name', 'slug'])
                    ->toArray(),

                'models' => VehicleModel::query()
                    ->with('make')
                    ->where('is_active', true)
                    ->orderBy('name')
                    ->get()
                    ->map(static fn(VehicleModel $model): array => [
                        'name' => $model->name,
                        'slug' => $model->slug,
                        'make_slug' => $model->make?->slug,
                    ])
                    ->values()
                    ->toArray(),

                'bodyTypes' => [
                    'sedan' => 'Sedan',
                    'suv' => 'SUV',
                    'coupe' => 'Coupe',
                    'truck' => 'Truck',
                    'hatchback' => 'Hatchback',
                    'van' => 'Van',
                    'wagon' => 'Wagon',
                    'convertible' => 'Convertible',
                ],

                'transmissions' => [
                    'automatic' => 'Automatic',
                    'manual' => 'Manual',
                    'cvt' => 'CVT',
                ],

                'drivetrains' => [
                    'fwd' => 'FWD',
                    'rwd' => 'RWD',
                    'awd' => 'AWD',
                    '4wd' => '4WD',
                ],

                'colors' => Vehicle::query()
                    ->whereNotNull('exterior_color')
                    ->where('exterior_color', '!=', '')
                    ->distinct()
                    ->orderBy('exterior_color')
                    ->pluck('exterior_color')
                    ->values()
                    ->toArray(),
            ],
        ]);
    }
}
