<?php

namespace App\Providers;

use App\Classes\DataProvider\QuandlPriceData;
use App\Contracts\DataServiceInterface;
use App\Entities\Datasource;
use App\Exceptions\DataServiceException;
use App\Repositories\KeyfigureRepository;
use App\Services\DataService;
use Illuminate\Support\ServiceProvider;

class KeyfigureRepositoryProvider extends ServiceProvider
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
    }
}
