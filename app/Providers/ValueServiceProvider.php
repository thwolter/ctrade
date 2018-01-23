<?php

namespace App\Providers;

use App\Services\ValueService\ValueService;
use Illuminate\Support\ServiceProvider;


class ValueServiceProvider extends ServiceProvider
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
        $this->app->bind('valueService', ValueService::class);
    }
}
