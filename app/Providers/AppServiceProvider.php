<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Dusk\DuskServiceProvider;
use Laravel\Horizon\Horizon;

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
            'Stock' => \App\Entities\Stock::class,
            'CcyPair' => \App\Entities\CcyPair::class
        ]);

        // Choose who can see the horizon dashboard
        Horizon::auth(function ($request) {
            $user = auth()->user();
            return ($user) ? $user->hasRole('admin') : null;
        });



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
