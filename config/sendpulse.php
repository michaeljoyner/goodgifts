<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | API Keys
    |--------------------------------------------------------------------------
    |
    | You can find your API keys via the SendPulse dashboard at https://login.sendpulse.com/settings/#api
    |
    */

    'apiUserId' => env('SEND_PULSE_ID'),

    'apiSecret' => env('SEND_PULSE_ID'),

    /*
    |--------------------------------------------------------------------------
    | Application Settings
    |--------------------------------------------------------------------------
    |
    */

    // Where to save the generated SendPulse API bearer token
    'tokenStorage' => 'session', //session, memcache or file
);