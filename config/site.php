<?php

declare(strict_types=1);

return [
    'name' => env('SITE_NAME', 'Marick Auto Sales'),
    'tagline' => env('SITE_TAGLINE', 'Premium vehicle inventory'),

    'phone' => env('SITE_PHONE', '+1 (203) 630-2886'),
    'phone_tel' => env('SITE_PHONE_TEL', '+12036302886'),

    'email' => env('SITE_EMAIL', 'sales@marickautosales.com'),

    'address' => env('SITE_ADDRESS', '197 Pratt St, Meriden, CT 06450, USA'),
    'maps_url' => env('SITE_MAPS_URL', 'https://www.google.com/maps/place/?q=place_id:ChIJn80XbBjK54kRZGKl1WkbGDs'),
    'maps_embed_url' => env('SITE_MAPS_EMBED_URL', 'https://www.google.com/maps?q=197%20Pratt%20St%2C%20Meriden%2C%20CT%2006450%2C%20USA&output=embed'),

    'city' => env('SITE_CITY', 'Meriden'),
    'state' => env('SITE_STATE', 'CT'),
    'zip' => env('SITE_ZIP', '06450'),
    'country' => env('SITE_COUNTRY', 'USA'),

    'business_hours' => env('SITE_BUSINESS_HOURS', 'Mon–Fri 9:00 AM – 5:00 PM'),

    'logo' => env('SITE_LOGO', '/images/logo.png'),
];
