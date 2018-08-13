<?php

namespace App\Providers;

use App\Entities\CcyPair;
use App\Entities\Dataset;
use App\Entities\Datasource;
use App\Entities\Limit;
use App\Entities\Stock;
use App\Entities\Taker;
use App\Entities\User;
use App\Observers\CcyPairObserver;
use App\Observers\DatasourceObserver;
use App\Observers\LimitObserver;
use App\Observers\StockObserver;
use App\Observers\TakerObserver;
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
