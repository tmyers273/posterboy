<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Queue
    |--------------------------------------------------------------------------
    |
    | The name of the queue to dispatch the post jobs to
    */

    'queue' => 'posterboy_post',

    /*
    |--------------------------------------------------------------------------
    | Max Attempts
    |--------------------------------------------------------------------------
    |
    | This value is the number of times posterboy will attempt
    | to POST data to the endpoint before it fails.
    */

    'max_attempts' => 7,

    /*
    |--------------------------------------------------------------------------
    | Attempt Delay
    |--------------------------------------------------------------------------
    |
    | These values will determine how long to wait between retries of failed
    | webhooks. There should be a maximum of one less than max_attempts
    | and a minimum of one value. Values are in seconds.
    */

    'attempt_delays' => [
        1,
        3,
        10,
        30,
        60,
        180,
    ]

];