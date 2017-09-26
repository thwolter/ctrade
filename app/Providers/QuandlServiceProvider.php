<?php

namespace App\Providers;

use App\Classes\Metadata\Quandl\QuandlECB;
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

        $this->app->bind('QuandlPrices', function($app, $parameter) {
            return resolve('App\Classes\Metadata\Quandl\Quandl'.$parameter[0]);
        });
    }
}
