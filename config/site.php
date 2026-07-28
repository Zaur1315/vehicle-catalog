<?php

declare(strict_types=1);

return [
    'name' => env('SITE_NAME', 'Kohl Auto Sales'),
    'short_name' => env('SITE_SHORT_NAME', 'Kohl'),
    'tagline' => env('SITE_TAGLINE', 'Quality pre-owned vehicles'),
    'domain' => env('SITE_DOMAIN', ''),

    'phone' => env('SITE_PHONE', '+1 (717) 949-3580'),
    'phone_tel' => env('SITE_PHONE_TEL', '+17179493580'),

    'email' => env('SITE_EMAIL', ''),

    'address' => env('SITE_ADDRESS', 'Address available on Google Maps'),
    'maps_url' => env('SITE_MAPS_URL', 'https://www.google.com/maps/place/?q=place_id:ChIJ3fTNKuYOxokRF5M3j9cSCYs'),
    'maps_embed_url' => env('SITE_MAPS_EMBED_URL', ''),

    'city' => env('SITE_CITY', 'Pennsylvania'),
    'state' => env('SITE_STATE', 'PA'),
    'zip' => env('SITE_ZIP', ''),
    'country' => env('SITE_COUNTRY', 'USA'),

    'business_hours' => env('SITE_BUSINESS_HOURS', 'Mon–Fri 9:00 AM – 5:00 PM'),

    'logo' => env('SITE_LOGO', '/images/kohl-mark.svg'),
];
