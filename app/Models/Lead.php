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
}
