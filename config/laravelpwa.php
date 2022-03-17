<?php

return [
    'name' => 'LaravelPWA',
    'manifest' => [
        'name' => env('APP_NAME', 'My PWA App'),
        'short_name' => 'PWA',
        'start_url' => '/',
        'background_color' => '#f3f3f3',
        'theme_color' => '#FFAA1A',
        'display' => 'standalone',
        'orientation'=> 'any',
        'status_bar'=> 'black',
        'icons' => [
            '72x72' => [
                'path' => url('/uploads/icons/icon-72x72.png'),
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => url('/uploads/icons/icon-96x96.png'),
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => url('/uploads/icons/icon-128x128.png'),
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => url('/uploads/icons/icon-144x144.png'),
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => url('/uploads/icons/icon-152x152.png'),
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => url('/uploads/icons/icon-192x192.png'),
                'purpose' => 'any'
            ],
            '284x284' => [
                'path' => url('/uploads/icons/icon-384x384.png'),
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => url('/uploads/icons/icon-512x512.png'),
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => '/images/icons/splash-640x1136.png',
            '750x1334' => '/images/icons/splash-750x1334.png',
            '828x1792' => '/images/icons/splash-828x1792.png',
            '1125x2436' => '/images/icons/splash-1125x2436.png',
            '1242x2208' => '/images/icons/splash-1242x2208.png',
            '1242x2688' => '/images/icons/splash-1242x2688.png',
            '1536x2048' => '/images/icons/splash-1536x2048.png',
            '1668x2224' => '/images/icons/splash-1668x2224.png',
            '1668x2388' => '/images/icons/splash-1668x2388.png',
            '2048x2732' => '/images/icons/splash-2048x2732.png',
        ],
        'shortcuts' => [],
        'custom' => []
    ]
];
