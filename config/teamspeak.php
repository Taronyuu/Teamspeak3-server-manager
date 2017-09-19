<?php

return [

    /*
    |--------------------------------------------------------------------------
    | TeamSpeak Server Query Credentials
    |--------------------------------------------------------------------------
    |
    | The password can be generated either when you install your server
    | or if you have permission to create a new login from
    | the Tools => ServerQuery Login menu option
    |
    */

    'ip' => env('TS_SERVER_IP', '127.0.0.1'),
    'port' => env('TS_SERVER_PORT', '10011'),
    'username' => env('TS_USERNAME', 'serveradmin'),
    'password' => env('TS_PASSWORD', ''),

];
