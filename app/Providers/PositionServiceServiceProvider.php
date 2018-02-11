<?php

namespace App\Providers;

use App\Services\AssetService;
use App\Services\PositionService;
use Illuminate\Support\ServiceProvider;

class PositionServiceServiceProvider extends ServiceProvider
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
        $this->app->bind('positionService', PositionService::class);
    }
}
