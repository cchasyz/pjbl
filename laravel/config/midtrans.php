<?php

return [
    'server_key' => env('MIDTRANS_SERVER_KEY', 'YOUR_SERVER_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => true,
    'is_3ds' => true,
];
