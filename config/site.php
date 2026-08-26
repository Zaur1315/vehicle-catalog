<?php

declare(strict_types=1);

return [
    'name' => env('SITE_NAME', 'Delmar Auto Sale Inc.'),
    'short_name' => env('SITE_SHORT_NAME', 'Delmar'),
    'tagline' => env('SITE_TAGLINE', 'Quality pre-owned vehicles in Salisbury, Maryland'),
    'domain' => env('SITE_DOMAIN', 'delmarautosales-md.com'),

    'phone' => env('SITE_PHONE', '+1 410-543-1977'),
    'phone_tel' => env('SITE_PHONE_TEL', '+14105431977'),

    'email' => env('SITE_EMAIL', 'sales@delmarautosales-md.com'),

    'address' => env('SITE_ADDRESS', '28650 Ocean Gateway #2002, Salisbury, MD 21801, USA'),
    'maps_url' => env('SITE_MAPS_URL', ''),
    'maps_embed_url' => env('SITE_MAPS_EMBED_URL', ''),

    'city' => env('SITE_CITY', 'Salisbury'),
    'state' => env('SITE_STATE', 'MD'),
    'zip' => env('SITE_ZIP', '21801'),
    'country' => env('SITE_COUNTRY', 'USA'),

    'business_hours' => env('SITE_BUSINESS_HOURS', 'Monday–Friday: 9:00 AM – 5:00 PM'),

    'logo' => env('SITE_LOGO', ''),
];
