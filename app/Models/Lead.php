<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Lead extends Model
{
    public const TYPE_VEHICLE_INQUIRY = 'vehicle_inquiry';
    public const TYPE_CONTACT = 'contact';
    public const TYPE_FINANCE = 'finance';
    public const TYPE_TRADE_IN = 'trade_in';

    public const STATUS_NEW = 'new';
    public const STATUS_CONTACTED = 'contacted';
    public const STATUS_QUALIFIED = 'qualified';
    public const STATUS_CLOSED = 'closed';
    public const STATUS_SPAM = 'spam';

    protected $fillable = [
        'vehicle_id',
        'type',
        'first_name',
        'last_name',
        'email',
        'phone',
        'preferred_contact_time',
        'subject',
        'message',
        'status',
        'source',
        'payload',
    ];

    protected $casts = [
        'vehicle_id' => 'integer',
        'payload' => 'array',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function getCustomerNameAttribute(): string
    {
        return trim($this->first_name . ' ' . ($this->last_name ?? ''));
    }

    public function getPayloadSummaryAttribute(): string
    {
        $payload = $this->payload ?? [];

        if ($payload === []) {
            return '-';
        }

        return match ($this->type) {
            self::TYPE_FINANCE => sprintf(
                'Vehicle: %s | Amount: %s | Down: %s | Term: %s months | Credit: %s',
                $payload['vehicle_interest'] ?? '-',
                $payload['amount'] ?? '-',
                $payload['down_payment'] ?? '-',
                $payload['term_months'] ?? '-',
                $payload['credit_score_range'] ?? '-',
            ),

            self::TYPE_TRADE_IN => sprintf(
                '%s %s %s | Mileage: %s | Condition: %s | VIN: %s',
                $payload['year'] ?? '-',
                $payload['make'] ?? '-',
                $payload['model'] ?? '-',
                isset($payload['mileage']) ? number_format((int)$payload['mileage']) . ' mi' : '-',
                $payload['condition'] ?? '-',
                $payload['vin'] ?? '-',
            ),

            self::TYPE_VEHICLE_INQUIRY => sprintf(
                'Vehicle: %s | Stock: %s | VIN: %s',
                $payload['vehicle_name'] ?? '-',
                $payload['stock_number'] ?? '-',
                $payload['vin'] ?? '-',
            ),

            default => '-',
        };
    }
}
