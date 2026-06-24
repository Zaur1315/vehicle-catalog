<?php

declare(strict_types=1);

namespace App\Services\Lead;

use App\Models\Lead;
use App\Models\Vehicle;

final readonly class VehicleLeadService
{
    /**
     * @param array{
     *     first_name:string,
     *     last_name?:string|null,
     *     phone:string,
     *     email?:string|null,
     *     preferred_contact_time?:string|null,
     *     message?:string|null
     * } $data
     */
    public function createFromVehicle(Vehicle $vehicle, array $data): Lead
    {
        /** @var Lead $lead */
        $lead = Lead::query()->create([
            'vehicle_id' => $vehicle->id,
            'type' => Lead::TYPE_VEHICLE_INQUIRY,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'],
            'preferred_contact_time' => $data['preferred_contact_time'] ?? null,
            'subject' => sprintf('Vehicle inquiry: %s', $vehicle->name),
            'message' => $data['message'] ?? null,
            'status' => Lead::STATUS_NEW,
            'source' => 'vehicle_page',
            'payload' => [
                'vehicle_name' => $vehicle->name,
                'vehicle_slug' => $vehicle->slug,
                'stock_number' => $vehicle->stock_number,
                'vin' => $vehicle->vin,
            ],
        ]);

        return $lead;
    }
}
