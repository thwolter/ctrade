<?php

namespace App\Providers;

use App\Services\RiskService\RiskService;
use Illuminate\Support\ServiceProvider;


class RiskServiceProvider extends ServiceProvider
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
        $this->app->bind('riskService', RiskService::class);
    }
}
