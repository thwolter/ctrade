<?php

namespace App\Providers;

use App\Repositories\DataProvider\QuandlPriceData;
use Illuminate\Support\ServiceProvider;

class DataServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('QuandlPriceData', function ($app, $parameter) {
            return new QuandlPriceData($parameter[0]);
        });

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
