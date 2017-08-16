<?php

namespace App\Providers;

use App\Repositories\Metadata\Quandl\QuandlECB;
use App\Repositories\Metadata\Quandl\QuandlSSE;
use Illuminate\Support\ServiceProvider;

class MetadataServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Quandl/SSE', function($app) { return new QuandlSSE(); });
        $this->app->bind('Quandl/FSE', function($app) { return new QuandlSSE(); });
        $this->app->bind('Quandl/ECB', function($app) { return new QuandlECB(); });
    }
}
