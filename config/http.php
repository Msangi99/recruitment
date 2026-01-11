<?php

return [
    /*
    |--------------------------------------------------------------------------
    | HTTP Client Default Options
    |--------------------------------------------------------------------------
    |
    | Default options for HTTP client requests
    |
    */

    'defaults' => [
        'verify' => env('SELCOM_VERIFY_SSL', env('APP_ENV') === 'local' ? false : true),
        'timeout' => 30,
        'curl' => [
            CURLOPT_SSL_VERIFYPEER => env('SELCOM_VERIFY_SSL', env('APP_ENV') === 'local' ? false : true),
            CURLOPT_SSL_VERIFYHOST => env('SELCOM_VERIFY_SSL', env('APP_ENV') === 'local' ? false : true) ? 2 : 0,
        ],
    ],
];
