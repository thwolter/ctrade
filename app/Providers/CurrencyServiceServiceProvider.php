<?php

namespace App\Providers;

use App\Services\CurrencyService;
use App\Services\StockService;
use Illuminate\Support\ServiceProvider;

class CurrencyServiceServiceProvider extends ServiceProvider
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
        $this->app->bind('currencyService', CurrencyService::class);

    }
}
