<?php

return [
    'google' => [
        'config' => [
            'application_name' => env('GOOGLE_API_NAME'),
            'client_id' => env('GOOGLE_API_CLIENT_ID'),
            'client_secret' => env('GOOGLE_API_CLIENT_SECRET'),
            'developer_key' => env('GOOGLE_API_KEY'),
        ],
    ],

    'google_sheets' => [
        'id' => env('GOOGLE_SHEETS_ID'),
        'range' => env('GOOGLE_SHEETS_RANGE'),
        'products_id' => env('GOOGLE_SHEETS_PRODUCTS_ID'),
    ],
];
