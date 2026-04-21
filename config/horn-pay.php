<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Payment Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default payment driver that will be used.
    |
    */
    'default' => env('HORN_PAY_DRIVER', 'waafi'),

    /*
    |--------------------------------------------------------------------------
    | Payment Drivers
    |--------------------------------------------------------------------------
    |
    | Here you may configure the settings for each driver.
    |
    */
    'drivers' => [
        'waafi' => [
            'api_key' => env('WaafiApiKeyApiKey'),
            'merchant_id' => env('MerchantUid'),
            'user_id' => env('ApiUserId'),
            'password' => env('WAAFI_PASSWORD'),
            'base_url' => env('WAAFI_BASE_URL', 'https://api.waafipay.com/asm'),
            'redirect_url' => env('WAAFI_REDIRECT_URL'),
            'payment_method' => env('WAAFI_PAYMENT_METHOD', 'MWALLET_ACCOUNT'), // ZAAD, SAHAL, etc.
        ],

        'edahab' => [
            'api_key' => env('EDAHAB_API_KEY'),
            'agent_code' => env('EDAHAB_AGENT_CODE'),
            'secret_key' => env('EDAHAB_SECRET_KEY'),
            'base_url' => env('EDAHAB_BASE_URL', 'https://edahab.net/api/api/IssueInvoice'),
            'return_url' => env('EDAHAB_RETURN_URL'),
        ],
    ],
];
