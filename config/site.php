<?php

declare(strict_types=1);

return [
    'name' => env('SITE_NAME', 'Auto Dealer'),
    'tagline' => env('SITE_TAGLINE', 'Premium vehicle inventory'),

    'phone' => env('SITE_PHONE', '+1 (000) 000-0000'),
    'phone_link' => env('SITE_PHONE_TEL', '+10000000000'),
    'email' => env('SITE_EMAIL', 'sales@example.com'),
    'address' => env('SITE_ADDRESS', 'Dealer address will be added before production launch.'),
    'business_hours' => env('SITE_BUSINESS_HOURS', 'Mon–Fri 9:00 AM – 5:00 PM'),

    'logo' => env('SITE_LOGO', '/images/logo.png'),
];
