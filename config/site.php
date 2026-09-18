<?php

declare(strict_types=1);

return [
    'name' => env('SITE_NAME', 'Advantage Auto Sales'),
    'short_name' => env('SITE_SHORT_NAME', 'Advantage Auto'),
    'tagline' => env('SITE_TAGLINE', 'A simpler way to find your next vehicle.'),
    'domain' => env('SITE_DOMAIN', 'advantageautosales-pa.com'),

    'phone' => env('SITE_PHONE', '(724) 437-7748'),
    'phone_tel' => env('SITE_PHONE_TEL', '+17244377748'),

    'email' => env('SITE_EMAIL', 'sales@advantageautosales-pa.com'),

    'address' => env('SITE_ADDRESS', '1026 National Pike, Uniontown, PA 15401'),
    'street_address' => env('SITE_STREET_ADDRESS', '1026 National Pike'),
    'maps_url' => env('SITE_MAPS_URL', 'https://www.google.com/maps/search/?api=1&query=1026+National+Pike+Uniontown+PA+15401'),
    'maps_embed_url' => env('SITE_MAPS_EMBED_URL', 'https://www.google.com/maps?q=1026+National+Pike,+Uniontown,+PA+15401&output=embed'),

    'city' => env('SITE_CITY', 'Uniontown'),
    'state' => env('SITE_STATE', 'PA'),
    'zip' => env('SITE_ZIP', '15401'),
    'country' => env('SITE_COUNTRY', 'US'),

    'business_hours' => env('SITE_BUSINESS_HOURS', ''),

    'logo' => env('SITE_LOGO', '/images/brand/advantage-logo-dark.svg'),
    'logo_light' => env('SITE_LOGO_LIGHT', '/images/brand/advantage-logo-light.svg'),
    'mark' => env('SITE_MARK', '/images/brand/advantage-mark.svg'),
];
