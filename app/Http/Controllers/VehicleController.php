<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Lead\StoreVehicleInquiryRequest;
use App\Models\Vehicle;
use App\Services\Lead\VehicleLeadService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class VehicleController extends Controller
{
    public function show(Vehicle $vehicle): Response
    {
        abort_unless($vehicle->is_active, 404);
        abort_unless($vehicle->status === Vehicle::STATUS_AVAILABLE, 404);

        $vehicle->load(['make', 'vehicleModel', 'images']);

        $relatedVehicles = Vehicle::query()
            ->with(['make', 'vehicleModel'])
            ->where('id', '!=', $vehicle->id)
            ->where('vehicle_make_id', $vehicle->vehicle_make_id)
            ->where('is_active', true)
            ->where('status', Vehicle::STATUS_AVAILABLE)
            ->limit(3)
            ->get()
            ->map(static fn(Vehicle $relatedVehicle): array => [
                'id' => $relatedVehicle->id,
                'name' => $relatedVehicle->name,
                'slug' => $relatedVehicle->slug,
                'year' => $relatedVehicle->year,
                'price' => $relatedVehicle->formatted_price,
                'mileage' => $relatedVehicle->formatted_mileage,
                'image' => $relatedVehicle->main_image_url,
            ]);

        return Inertia::render('Inventory/Show', [
            'vehicle' => [
                'id' => $vehicle->id,
                'name' => $vehicle->name,
                'slug' => $vehicle->slug,
                'stock_number' => $vehicle->stock_number,
                'vin' => $vehicle->vin,
                'year' => $vehicle->year,
                'price' => $vehicle->formatted_price,
                'mileage' => $vehicle->formatted_mileage,
                'condition' => $vehicle->condition,
                'body_type' => $vehicle->body_type,
                'transmission' => $vehicle->transmission,
                'drivetrain' => $vehicle->drivetrain,
                'engine' => $vehicle->engine,
                'fuel_type' => $vehicle->fuel_type,
                'exterior_color' => $vehicle->exterior_color,
                'interior_color' => $vehicle->interior_color,
                'short_description' => $vehicle->short_description,
                'description' => $vehicle->description,
                'features' => $vehicle->features ?? [],
                'main_image' => $vehicle->main_image_url,
                'make' => $vehicle->make?->name,
                'model' => $vehicle->vehicleModel?->name,
                'images' => $vehicle->images
                    ->map(static fn($image): array => [
                        'url' => $image->url,
                        'alt' => $image->alt,
                        'sort_order' => $image->sort_order,
                        'is_main' => $image->is_main,
                    ])
                    ->values(),
            ],
            'relatedVehicles' => $relatedVehicles,
        ]);
    }

    public function inquiry(
        StoreVehicleInquiryRequest $request,
        Vehicle                    $vehicle,
        VehicleLeadService         $vehicleLeadService,
    ): RedirectResponse
    {
        abort_unless($vehicle->is_active, 404);
        abort_unless($vehicle->status === Vehicle::STATUS_AVAILABLE, 404);

        $vehicleLeadService->createFromVehicle($vehicle, $request->validated());

        return back()->with('success', 'Your request has been sent. Our sales team will contact you soon.');
    }
}
