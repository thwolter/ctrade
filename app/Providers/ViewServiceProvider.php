<?php

namespace App\Providers;

use App\Http\ViewComposers\ChartComposer;
use App\Http\ViewComposers\LimitRepositoryComposer;
use App\Http\ViewComposers\StockMetricComposer;

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

        View::composer('portfolios.index', LimitRepositoryComposer::class);

        View::composer('positions.show_stock', StockMetricComposer::class);
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
