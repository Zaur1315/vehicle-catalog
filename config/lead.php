<?php

declare(strict_types=1);

return [
    'notification_email' => env('LEAD_NOTIFICATION_EMAIL'),
    'notification_from_name' => env('LEAD_NOTIFICATION_FROM_NAME', env('SITE_NAME', 'Delmar Auto Sale Inc.')),
];
