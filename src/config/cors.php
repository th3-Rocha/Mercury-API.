<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => array_map('trim', explode(',', env('CORS_ALLOWED_METHODS', '*'))),

    'allowed_origins' => array_map('trim', explode(',', env('CORS_ALLOWED_ORIGINS', 'http://localhost:3000'))),

    'allowed_origins_patterns' => [],

    'allowed_headers' => array_map('trim', explode(',', env('CORS_ALLOWED_HEADERS', '*'))),

    'exposed_headers' => array_filter(array_map('trim', explode(',', env('CORS_EXPOSED_HEADERS', '')))),

    'max_age' => env('CORS_MAX_AGE', 0),

    'supports_credentials' => env('CORS_SUPPORTS_CREDENTIALS', true),
];
