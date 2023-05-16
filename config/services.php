<?php

declare(strict_types=1);

use function App\env;

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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT', 'http://localhost/auth/google'),
        'redirect_youtube' => env('YOUTUBE_REDIRECT', 'http://localhost/api/v1/auth/youtube/callback'),
    ],

    'facebook' => [
        'client_id' => env('FB_CLIENT_ID'),
        'client_secret' => env('FB_CLIENT_SECRET'),
        'redirect' => env('FB_REDIRECT', 'http://localhost/auth/facebook/'),
    ],

    'search' => [
        'hosts' => explode(',', env('ELASTICSEARCH_HOSTS', 'elasticsearch:9200')),
    ],

    'mail' => [
        'link' => env('FRONTEND_URL') . '/manager/confirm/',
        'link_agency_confirm' => env('FRONTEND_URL') . '/manager/agency/confirm/',
    ],
];
