<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class QuandlServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('QuandlClient', function($app) {

            $client = new \Quandl(config('quandl.api_key'),'json');
            $client->timeout = config('quandl.timeout');

            return $client;
        });
    }
}
