<?php

return [
    /*
    |--------------------------------------------------------------------------
    | AzamPay App Name
    |--------------------------------------------------------------------------
    |
    | Your application name registered with AzamPay
    */
    'app_name' => env('AZAMPAY_APP_NAME'),

    /*
    |--------------------------------------------------------------------------
    | Client ID
    |--------------------------------------------------------------------------
    |
    | Your AzamPay client ID
    */
    'client_id' => env('AZAMPAY_CLIENT_ID'),

    /*
    |--------------------------------------------------------------------------
    | Client Secret
    |--------------------------------------------------------------------------
    |
    | Your AzamPay client secret
    */
    'client_secret' => env('AZAMPAY_CLIENT_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Environment
    |--------------------------------------------------------------------------
    |
    | Set to 'sandbox' for testing or 'production' for live payments
    */
    'environment' => env('AZAMPAY_ENVIRONMENT', 'sandbox'),

    /*
    |--------------------------------------------------------------------------
    | Token
    |--------------------------------------------------------------------------
    |
    | AzamPay API token (optional, can be generated automatically)
    */
    'token' => env('AZAMPAY_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | API URLs
    |--------------------------------------------------------------------------
    |
    | AzamPay API endpoints
    */
    'urls' => [
        'sandbox' => 'https://sandbox.azampay.co.tz',
        'production' => 'https://checkout.azampay.co.tz',
    ],

    /*
    |--------------------------------------------------------------------------
    | Webhook URL
    |--------------------------------------------------------------------------
    |
    | URL where AzamPay will send payment callbacks
    */
    'webhook_url' => env('AZAMPAY_WEBHOOK_URL', '/azampay/webhook'),

    /*
    |--------------------------------------------------------------------------
    | Redirect URLs
    |--------------------------------------------------------------------------
    |
    | URLs for payment success and failure redirects
    */
    'redirect_url' => env('AZAMPAY_REDIRECT_URL', '/azampay/redirect'),
    'cancel_url' => env('AZAMPAY_CANCEL_URL', '/azampay/cancel'),

    /*
    |--------------------------------------------------------------------------
    | Supported Providers
    |--------------------------------------------------------------------------
    |
    | Mobile money providers supported by AzamPay
    */
    'providers' => [
        'Mpesa',
        'Tigo Pesa',
        'Airtel',
        'Azampay',
    ],
];
