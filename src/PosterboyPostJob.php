<?php

namespace tmyers273\posterboy;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PosterboyPostJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    protected $endpoint;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $endpoint)
    {
        $this->data = $data;
        $this->endpoint = $endpoint;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo("| Starting post to $this->endpoint\n");

        echo("| Attempts: " . $this->attempts() . "\n");

        echo("<pre>");
        print_r(config('poasterboy.max_attempts'));

        $attempts = $this->attempts();
        if ($attempts > config('posterboy.max_attempts')) {
            echo("| Reached max attempts. Deleting...");
            $this->delete();
            echo(" done\n");
            return;
        }

        $guzzler = new Client();

        echo("| Starting post...");
        $result = $guzzler->request('POST', $this->endpoint, [
            'body' => $this->data
        ]);
        echo(" done\n");

        $status = $result->getStatusCode();
        echo("| Got http code: $status\n");

        if ($status >= 200 && $status <= 299 ) {
            $this->delete();
            return;
        } else {
            $delay = $this->getDelay($attempts, config('posterboy.attempt_delays'));
            $this->fail();
            echo("| Releasing in $delay seconds\n");
            $this->release($delay);
            return;
        }
    }

    public function getDelay($attempts, $delays)
    {
        if (isset($delays[$attempts-1])) {
            return $delays[$attempts-1];
        } else {
            return collect($delays)->last();
        }
    }
}
