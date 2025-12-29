<?php

return [
    'code' => env('JAYAPAY_MERCHANT_CODE', ''),
    'endpoint' => env('JAYAPAY_ENDPOINT_URL', ''),
    'url' => env('JAYAPAY_NOTIFY_URL', '') . '/api/qr',
    'name' => env('JAYAPAY_MERCHANT_NAME', ''),
    'number' => env('JAYAPAY_MERCHANT_NUMBER', ''),
    'public_key' => env('JAYAPAY_PLATFORM_PUBLIC_KEY', ''),
    'private_key' => env('JAYAPAY_PLATFORM_PRIVATE_KEY', ''),
];
