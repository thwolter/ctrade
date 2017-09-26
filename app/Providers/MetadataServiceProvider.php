<?php

namespace App\Providers;

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
        $this->app->bind('UpdateQuandl', function($app, $parameter) {
            return resolve('App\Jobs\Metadata\UpdateQuandl'.$parameter[0]);
        });
    }
}
