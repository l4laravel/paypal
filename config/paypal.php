<?php
/**
 * Paypal config and settings
 */

return [
    // Sandbox
    'sandbox.client_id' => env('PAYPAL_SANDBOX_CLIENT_ID'),
    'sandbox.secret' => env('PAYPAL_SANDBOX_SECRET'),

    // Live
    'live.client_id' => env('PAYPAL_LIVE_CLIENT_ID'),
    'live.secret' => env('PAYPAL_LIVE_SECRET'),

    // Paypal SDK Configurations

    'settings' => [
        // Mode (live or sandbox)
        'mode' => env('PAypal_mode','sandbox'),
        // Connection timeout
        'http.ConnectionTimeOut' => 3000,
        // Logs
        'log.LongEnabled' => true,
        'log.FileName' => storage_path().'/logs/paypal.log',
        // Level: Debug info error
        'log.LogLevel' => 'DEBUG'

    ]


];














































