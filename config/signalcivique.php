<?php

return [
    'dashboard_cache_ttl' => (int) env('DASHBOARD_CACHE_TTL', 60),

    'media' => [
        'temporary_url_minutes' => (int) env('MEDIA_TEMPORARY_URL_MINUTES', 10),
        'max_size_kb' => 5120,
        'mimes' => [
            'image/jpeg',
            'image/png',
            'image/webp',
        ],
    ],
];
