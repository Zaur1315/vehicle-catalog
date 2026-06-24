<?php
declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lead\StoreProductLeadRequest;
use App\Models\Vehicle;
use App\Services\Lead\VehicleLeadService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

final class VehicleController extends Controller
{
    public function show(Vehicle $vehicle): View
    {
        abort_if(!$vehicle->is_active, 404);

        $vehicle->load([
            'vehicle_model',
            'vehicle_make',
            'images',
            'specifications',
        ]);

        $relatedVehicle = Vehicle::query()
            ->with(['vehicle_make', 'vehicle_model'])
            ->where('is_active', true)
            ->where('category_id', $vehicle->category_id)
            ->whereKeyNot($vehicle->id)
            ->latest()
            ->limit(4)
            ->get();

        return view('front.products.show', [
            'vehicle' => $vehicle,
            'relatedVehicles' => $relatedVehicle,
        ]);
    }

    public function quote(
        StoreProductLeadRequest $request,
        Vehicle                 $vehicle,
        VehicleLeadService      $leadService,
    ): RedirectResponse
    {
        abort_if(!$vehicle->is_active, 404);

        $leadService->createFromVehicle($vehicle, $request->validated());

        return redirect()
            ->route('products.show', $vehicle)
            ->with('success', 'Thank you! Your quote request has been sent successfully.');
    }
}
