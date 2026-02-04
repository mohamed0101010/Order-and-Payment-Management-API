<?php

return [
    'enabled' => explode(',', env('PAYMENT_GATEWAYS', 'credit_card,paypal')),

    'credit_card' => [
        'api_key' => env('CC_API_KEY'),
    ],

    'paypal' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'secret' => env('PAYPAL_SECRET'),
    ],
];
