<?php

namespace tmyers273\posterboy;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class PosterboyServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/posterboy.php' => config_path('posterboy.php'),
        ]);
    }

    /**
     * @return void
     */
    public function register()
    {
        config([
            'config/posterboy.php',
        ]);
    }
}