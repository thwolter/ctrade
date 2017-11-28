<?php

namespace App\Providers;

use App\Classes\DataProvider\QuandlPriceData;
use App\Contracts\DataServiceInterface;
use App\Entities\Datasource;
use App\Entities\Limit;
use App\Exceptions\DataServiceException;
use App\Classes\Limits\AbstractLimit;
use Illuminate\Support\ServiceProvider;

class LimitServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(AbstractLimit::class, function ($app, $parameter)
        {
            $limit = $parameter[0];

            throw_if(get_class($limit) !== Limit::class,
                "Class {Limit::class} required.");

            $type = ucfirst(camel_case($limit->type));

            return $this->app
                ->makeWith("App\Classes\Limits\\{$type}Limit", ['limit' => $limit]);
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
