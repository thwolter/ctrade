<?php

namespace App\Providers;

use App\Repositories\KeyfigureRepository;
use App\Repositories\LimitRepository;
use App\Repositories\PortfolioRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
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
        $this->app->bind('keyfigureRepository', KeyfigureRepository::class);

        $this->app->bind('portfolioRepository', PortfolioRepository::class);

        $this->app->bind('limitRepository', LimitRepository::class);
    }
}
