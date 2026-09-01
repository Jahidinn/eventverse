<?php

$mode = env('MIDTRANS_ENVIRONMENT', 'sandbox');

return [

    'merchant_id' => env(
        $mode === 'production'
            ? 'MIDTRANS_MERCHANT_ID_PRODUCTION'
            : 'MIDTRANS_MERCHANT_ID_SANDBOX'
    ),

    'server_key' => env(
        $mode === 'production'
            ? 'MIDTRANS_SERVER_KEY_PRODUCTION'
            : 'MIDTRANS_SERVER_KEY_SANDBOX'
    ),

    'base_url' => $mode === 'production'
        ? 'https://api.midtrans.com'
        : 'https://api.sandbox.midtrans.com',

    'is_production' => $mode === 'production',

];