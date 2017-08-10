<?php

namespace App\Providers;

use App\Entities\Datasource;
use App\Entities\Limit;
use App\Entities\Portfolio;
use App\Entities\User;
use App\Observers\DatasourceObserver;
use App\Observers\LimitObserver;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Dusk\DuskServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // required for migrate ot use utf8mb4
        Schema::defaultStringLength(191);

        Relation::morphMap([
            'stock' => \App\Entities\Stock::class,
            'ccyPair' => \App\Entities\CcyPair::class
        ]);

        Limit::observe(LimitObserver::class);
        Datasource::observe(DatasourceObserver::class);
        User::observe(UserObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
