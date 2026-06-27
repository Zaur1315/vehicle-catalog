<?php

declare(strict_types=1);

namespace App\Support;

final class LeadFormType
{
    public const CONTACT = 'contact';
    public const VEHICLE_INQUIRY = 'vehicle_inquiry';
    public const FINANCE = 'finance';
    public const TRADE_IN = 'trade_in';
    public const DELIVERY = 'delivery';
    public const WARRANTY = 'warranty';

    public static function label(string $type): string
    {
        return match ($type) {
            self::VEHICLE_INQUIRY => 'Vehicle Inquiry',
            self::FINANCE => 'Finance Request',
            self::TRADE_IN => 'Trade-In Request',
            self::DELIVERY => 'Delivery Question',
            self::WARRANTY => 'Warranty Question',
            default => 'Contact Form',
        };
    }
}
