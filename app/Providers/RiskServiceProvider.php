<?php

namespace App\Providers;

use App\Services\RiskService;
use Illuminate\Support\ServiceProvider;
use App\Services\RscriptService\RscriptService;


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
