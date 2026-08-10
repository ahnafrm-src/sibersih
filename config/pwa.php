<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Would you like the install button to appear on all pages?
      Set true/false
    |--------------------------------------------------------------------------
    */

    'install-button' => true,

    /*
    |--------------------------------------------------------------------------
    | PWA Manifest Configuration
    |--------------------------------------------------------------------------
    |  php artisan erag:update-manifest
    */

    'manifest' => [
        'name'             => 'SI-BERSIH',
        'short_name'       => 'SI-BERSIH',
        'description'      => 'Monitoring kebersihan pasca-MBG',
        'theme_color'      => '#2F6D4F',   // --green dari design system lo
        'background_color' => '#EEF2ED',   // --bg dari design system lo
        'display'          => 'standalone',
        'start_url'        => '/lapor',    // langsung buka form lapor
        'icons'            => [
            [
                'src'   => 'logo.png',     // taruh di public/logo.png
                'sizes' => '512x512',
                'type'  => 'image/png',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Debug Configuration
    |--------------------------------------------------------------------------
    | Toggles the application's debug mode based on the environment variable
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Livewire Integration
    |--------------------------------------------------------------------------
    | Set to true if you're using Livewire in your application to enable
    | Livewire-specific PWA optimizations or features.
    */

    'livewire-app' => false,
];
