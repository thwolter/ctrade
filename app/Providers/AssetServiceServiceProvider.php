<?php

namespace App\Providers;

use App\Services\AssetService;
use Illuminate\Support\ServiceProvider;

class AssetServiceServiceProvider extends ServiceProvider
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
        $this->app->bind('assetService', AssetService::class);
    }
}
