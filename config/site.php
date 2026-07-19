<?php

declare(strict_types=1);

return [
    'name' => env('SITE_NAME', 'Cars For Less'),
    'tagline' => env('SITE_TAGLINE', 'Sales & Service'),

    'phone' => env('SITE_PHONE', '+1 (860) 421-9675'),
    'phone_tel' => env('SITE_PHONE_TEL', '+18604219675'),

    'email' => env('SITE_EMAIL', 'carsforlesseric@gmail.com'),

    'address' => env('SITE_ADDRESS', '108a Rainbow Rd, East Granby, CT 06026, USA'),
    'maps_url' => env('SITE_MAPS_URL', 'https://www.google.com/maps/place/?q=place_id:ChIJ10Eeef8B54kRUot88cP3aSg'),
    'maps_embed_url' => env('SITE_MAPS_EMBED_URL', 'https://www.google.com/maps?q=108a%20Rainbow%20Rd%2C%20East%20Granby%2C%20CT%2006026%2C%20USA&output=embed'),

    'city' => env('SITE_CITY', 'East Granby'),
    'state' => env('SITE_STATE', 'CT'),
    'zip' => env('SITE_ZIP', '06026'),
    'country' => env('SITE_COUNTRY', 'USA'),

    'business_hours' => env('SITE_BUSINESS_HOURS', 'Mon–Fri 9:00 AM – 5:00 PM'),

    'logo' => env('SITE_LOGO', '/images/logo.png'),
];
