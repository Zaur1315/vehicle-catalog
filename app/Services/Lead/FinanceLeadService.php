<?php

declare(strict_types=1);

namespace App\Services\Lead;

use App\Models\Lead;

final readonly class FinanceLeadService
{
    /**
     * @param array{
     *     first_name:string,
     *     last_name?:string|null,
     *     email?:string|null,
     *     phone:string,
     *     vehicle_interest?:string|null,
     *     amount?:numeric-string|int|float|null,
     *     down_payment?:numeric-string|int|float|null,
     *     term_months?:int|null,
     *     credit_score_range?:string|null,
     *     message?:string|null
     * } $data
     */
    public function create(array $data): Lead
    {
        /** @var Lead $lead */
        $lead = Lead::query()->create([
            'type' => Lead::TYPE_FINANCE,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'],
            'subject' => 'Finance pre-approval request',
            'message' => $data['message'] ?? null,
            'status' => Lead::STATUS_NEW,
            'source' => 'finance_page',
            'payload' => [
                'vehicle_interest' => $data['vehicle_interest'] ?? null,
                'amount' => $data['amount'] ?? null,
                'down_payment' => $data['down_payment'] ?? null,
                'term_months' => $data['term_months'] ?? null,
                'credit_score_range' => $data['credit_score_range'] ?? null,
            ],
        ]);

        return $lead;
    }
}
