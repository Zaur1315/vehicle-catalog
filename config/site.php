<?php

declare(strict_types=1);

return [
    'name' => env('SITE_NAME', 'Southern York Motors'),
    'short_name' => env('SITE_SHORT_NAME', 'Southern York'),
    'tagline' => env('SITE_TAGLINE', 'Your next chapter. Your next vehicle.'),
    'domain' => env('SITE_DOMAIN', 'southernyorkmotors.com'),

    'phone' => env('SITE_PHONE', '(717) 227-2202'),
    'phone_tel' => env('SITE_PHONE_TEL', '+17172272202'),

    'email' => env('SITE_EMAIL', 'sales@southernyorkmotors.com'),

    'address' => env('SITE_ADDRESS', '16591 Susquehanna Trail S, New Freedom, PA 17349, United States'),
    'street_address' => env('SITE_STREET_ADDRESS', '16591 Susquehanna Trail S'),
    'maps_url' => env('SITE_MAPS_URL', 'https://www.google.com/maps/search/?api=1&query=16591+Susquehanna+Trail+S+New+Freedom+PA+17349'),
    'maps_embed_url' => env('SITE_MAPS_EMBED_URL', ''),

    'city' => env('SITE_CITY', 'New Freedom'),
    'state' => env('SITE_STATE', 'PA'),
    'zip' => env('SITE_ZIP', '17349'),
    'country' => env('SITE_COUNTRY', 'US'),

    'business_hours' => env('SITE_BUSINESS_HOURS', ''),

    'logo' => env('SITE_LOGO', '/images/brand/southern-york-logo.svg'),
];
