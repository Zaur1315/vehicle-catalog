<?php

declare(strict_types=1);

namespace App\Services\Lead;

use App\Models\Lead;

final readonly class TradeInLeadService
{
    /**
     * @param array{
     *     first_name:string,
     *     last_name?:string|null,
     *     email?:string|null,
     *     phone:string,
     *     make:string,
     *     model:string,
     *     year:int,
     *     mileage:int,
     *     condition?:string|null,
     *     vin?:string|null,
     *     message?:string|null
     * } $data
     */
    public function create(array $data): Lead
    {
        /** @var Lead $lead */
        $lead = Lead::query()->create([
            'type' => Lead::TYPE_TRADE_IN,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'],
            'subject' => sprintf(
                'Trade-in request: %s %s %s',
                $data['year'],
                $data['make'],
                $data['model'],
            ),
            'message' => $data['message'] ?? null,
            'status' => Lead::STATUS_NEW,
            'source' => 'trade_in_page',
            'payload' => [
                'make' => $data['make'],
                'model' => $data['model'],
                'year' => $data['year'],
                'mileage' => $data['mileage'],
                'condition' => $data['condition'] ?? null,
                'vin' => $data['vin'] ?? null,
            ],
        ]);

        return $lead;
    }
}
