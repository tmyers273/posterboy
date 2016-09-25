<?php

namespace tmyers273\posterboy;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Queue;
use tmyers273\posterboy\PosterboyPostJob;

class Posterboy {

    public static function post($data, $endpoint) //@todo add user agent support and header support
    {
        if (! is_string($data)) {
            $data = json_encode($data);
        }

        $job = (new PosterboyPostJob($data, $endpoint))->onQueue(config('posterboy.queue'));

        return Bus::dispatch($job);
    }

}