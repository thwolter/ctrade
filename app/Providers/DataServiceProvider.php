<?php

namespace App\Providers;

use App\Classes\DataProvider\QuandlPriceData;
use App\Contracts\DataServiceInterface;
use App\Entities\Datasource;
use App\Exceptions\DataServiceException;
use Illuminate\Support\ServiceProvider;

class DataServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(DataServiceInterface::class, function ($app, $parameter) {
            $datasource = $parameter[0];

            if (get_class($datasource) !== Datasource::class)
                throw new DataServiceException('Given parameter must be a datasource.');

            switch ($datasource->provider->code) {
                case 'Quandl':
                    $service = new QuandlPriceData($datasource);
                    break;
                default:
                    throw new DataServiceException('Could not resolve datasource.');
            }
            return $service;
        });

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
