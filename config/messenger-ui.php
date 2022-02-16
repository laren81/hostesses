<?php

return [
    /*
    |--------------------------------------------------------------------------
    | The name of your application
    |--------------------------------------------------------------------------
    |
    */
    'site_name' => env('APP_NAME', 'Project'),

    /*
    |--------------------------------------------------------------------------
    | Websocket information we inject into our javascript. They should match
    | your pusher/laravel-websocket configs.
    |--------------------------------------------------------------------------
    |
    */
    'websocket' => [
        'pusher' => env('MESSENGER_SOCKET_PUSHER', true), //Set true if you are using the real pusher.com
        'host' => env('MESSENGER_SOCKET_HOST', 'localhost'),
        'auth_endpoint' => env('MESSENGER_SOCKET_AUTH_ENDPOINT', '/api/broadcasting/auth'),
        'key' => env('MESSENGER_SOCKET_KEY'),
        'port' => env('MESSENGER_SOCKET_PORT', 6001),
        'use_tsl' => env('MESSENGER_SOCKET_TLS', false),
        'cluster' => 'eu', //Only set when connecting to the real pusher.com
    ],

    /*
    |--------------------------------------------------------------------------
    | Messenger-UI web routes config
    |--------------------------------------------------------------------------
    |
    | Invite view / redemption routes have individual middleware control so
    | that you may allow both guest or authed users to access.
    |
    | *For the broadcasting channels to register, you must have already
    | setup/defined your laravel apps broadcast driver.
    |
    */
    'routing' => [
        'domain' => null,
        'prefix' => 'messenger',
        'middleware' => ['web', 'auth', 'messenger.provider'],
        'invite_middleware' => ['web', 'messenger.provider'],
    ],
];
