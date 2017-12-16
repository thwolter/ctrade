<?php

namespace App\Providers;

use App\Http\ViewComposers\ChartComposer;
use App\Http\ViewComposers\DataComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer([
            'portfolios.index',
            'portfolios.show'
        ], ChartComposer::class);

        View::composer([
            'positions.show*',
        ], DataComposer::class);
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
