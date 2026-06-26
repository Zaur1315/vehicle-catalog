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

    public static function labels(): array
    {
        return [
            self::CONTACT => 'Contact Form',
            self::VEHICLE_INQUIRY => 'Vehicle Inquiry',
            self::FINANCE => 'Finance Request',
            self::TRADE_IN => 'Trade-In Request',
            self::DELIVERY => 'Delivery Question',
            self::WARRANTY => 'Warranty Question',
        ];
    }

    public static function label(string $type): string
    {
        return self::labels()[$type] ?? 'Lead Form';
    }

    public static function allowed(): array
    {
        return array_keys(self::labels());
    }
}
