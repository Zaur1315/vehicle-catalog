<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google_places' => [
        'api_key' => env('GOOGLE_PLACES_API_KEY'),
        'place_id' => env('GOOGLE_PLACES_PLACE_ID'),
        'min_review_rating' => (int) env('GOOGLE_REVIEWS_MIN_RATING', 4),
    ],

    'resend' => [
        'key' => env('RESEND_KEY', env('RESEND_API_KEY')),
    ],

    'meta' => [
        'pixel_id' => env('META_PIXEL_ID'),
        'pixel_enabled' => (bool) env('META_PIXEL_ENABLED', false),

        'capi_enabled' => (bool) env('META_CAPI_ENABLED', false),
        'capi_access_token' => env('META_CAPI_ACCESS_TOKEN'),
        'capi_test_event_code' => env('META_CAPI_TEST_EVENT_CODE'),
        'capi_debug' => (bool) env('META_CAPI_DEBUG', false),
        'graph_api_version' => env('META_GRAPH_API_VERSION', 'v25.0'),
    ],

];
