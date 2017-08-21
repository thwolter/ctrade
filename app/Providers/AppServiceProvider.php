<?php

namespace App\Providers;

use App\Entities\Stock;
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
            'Stock' => \App\Entities\Stock::class,
            'CcyPair' => \App\Entities\CcyPair::class
        ]);



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
