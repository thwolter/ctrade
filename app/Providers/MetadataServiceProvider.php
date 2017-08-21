<?php

namespace App\Providers;

use App\Jobs\Metadata\UpdateQuandlECB;
use App\Jobs\Metadata\UpdateQuandlFSE;
use App\Jobs\Metadata\UpdateQuandlSSE;
use App\Repositories\Metadata\Quandl\QuandlECB;
use App\Repositories\Metadata\Quandl\QuandlFSE;
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
        $this->app->bind('Quandl/FSE', function($app) { return new QuandlFSE(); });
        $this->app->bind('Quandl/ECB', function($app) { return new QuandlECB(); });

        $this->app->bind('UpdateQuandl/SSE', function($app) { return new UpdateQuandlSSE(); });
        $this->app->bind('UpdateQuandl/FSE', function($app) { return new UpdateQuandlFSE(); });
        $this->app->bind('UpdateQuandl/ECB', function($app) { return new UpdateQuandlECB(); });
    }
}
