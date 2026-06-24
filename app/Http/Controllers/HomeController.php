<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class HomeController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $featuredVehicles = Vehicle::query()
            ->with(['make', 'vehicleModel'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->where('status', Vehicle::STATUS_AVAILABLE)
            ->latest()
            ->limit(6)
            ->get()
            ->map(static fn(Vehicle $vehicle): array => [
                'id' => $vehicle->id,
                'name' => $vehicle->name,
                'slug' => $vehicle->slug,
                'year' => $vehicle->year,
                'price' => $vehicle->formatted_price,
                'mileage' => $vehicle->formatted_mileage,
                'image' => $vehicle->main_image_url,
                'make' => $vehicle->make?->name,
                'model' => $vehicle->vehicleModel?->name,
            ])
            ->values();

        return Inertia::render('Home', [
            'featuredVehicles' => $featuredVehicles,
        ]);
    }
}
