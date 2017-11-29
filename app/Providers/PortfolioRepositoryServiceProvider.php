<?php

namespace App\Providers;

use App\Entities\Portfolio;
use App\Repositories\Contracts\PortfolioInterface;
use App\Repositories\PortfolioRepository;
use Illuminate\Support\ServiceProvider;

class PortfolioRepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(PortfolioInterface::class, function($app)
        {
            return new PortfolioRepository(new Portfolio());
        });
    }
}
