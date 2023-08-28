<?php

return [
    'vnpay' => [
        'version' => env('VNPAY_VERSION'),
        'merchant_id' => env('VNPAY_ID'),
        'merchant_secret' => env('VNPAY_SECRET'),
        'locale' => env('VNPAY_LOCALE'),
        'url' => env('VNPAY_URL'),
        'bankcode' => env('VNPAY_BANKCODE'),
        'currency' => env('VNPAY_CURR_CODE'),
    ],
];