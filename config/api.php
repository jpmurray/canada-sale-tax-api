<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application, which will be used when the
    | framework needs to place the application's name in a notification or
    | other UI elements where an application name needs to be displayed.
    |
    */

    'rates' => [
        'authed' => env('API_RATE_PER_MINUTES_AUTHED', 'Laravel'),
        'guest' => env('API_RATE_PER_MINUTES_GUEST', 'Laravel'),
    ],
    'retention' => [
        'hits' => env('HITS_RETENTION_MONTHS', 6),
    ],

];
