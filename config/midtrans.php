<?php

// return [
// 	'merchant_id' => env('MIDTRANS_MERCHANT_ID'),
// 	'client_key' => env('MIDTRANS_CLIENT_KEY'),
// 	'server_key' => env('MIDTRANS_SERVER_KEY'),
// 	'is_production' => env('MIDTRANS_IS_PRODUCTION'),
// 	'snap_url' => env('MIDTRANS_SNAP_URL'),
// ];

$mode = env('MIDTRANS_MODE', 'sandbox');

return [
    'merchant_id' => env(
        $mode === 'production'
            ? 'PROD_MIDTRANS_MERCHANT_ID'
            : 'MIDTRANS_MERCHANT_ID'
    ),

    'client_key' => env(
        $mode === 'production'
            ? 'PROD_MIDTRANS_CLIENT_KEY'
            : 'MIDTRANS_CLIENT_KEY'
    ),

    'server_key' => env(
        $mode === 'production'
            ? 'PROD_MIDTRANS_SERVER_KEY'
            : 'MIDTRANS_SERVER_KEY'
    ),

    'snap_url' => env(
        $mode === 'production'
            ? 'PROD_MIDTRANS_SNAP_URL'
            : 'MIDTRANS_SNAP_URL'
    ),

    'is_production' => $mode === 'production',
];