<?php

namespace App\Providers;

use App\Entities\Dataset;
use App\Entities\Limit;
use App\Entities\User;
use App\Observers\DatasourceObserver;
use App\Observers\LimitObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Limit::observe(LimitObserver::class);
        Dataset::observe(DatasourceObserver::class);
        User::observe(UserObserver::class);
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
