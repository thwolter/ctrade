<?php

namespace App\Providers;

use App\Classes\DataProvider\QuandlPriceData;
use App\Contracts\DataServiceInterface;
use App\Contracts\MetricServiceInterface;
use App\Entities\Datasource;
use App\Exceptions\DataServiceException;
use App\Exceptions\MetricServiceException;
use App\Services\MetricServices\MetricService;
use Illuminate\Support\ServiceProvider;

class MetricServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('MetricService', function ($app, $parameter) {

            $entity = $parameter[0];
            $service = $this->getServiceClass($entity);

            return new $service($entity);
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


    /**
     * Get the MetricServiceClass based on provided entity.
     *
     * @param $entity
     * @return string
     * @throws MetricServiceException
     */
    private function getServiceClass($entity)
    {
        $service = str_replace_last(
            'MetricService',
            class_basename(get_class($entity)) . 'MetricService',
            MetricService::class
        );

        if (!class_exists($service))
            throw new MetricServiceException("Class {$service} does not exist.");

        return $service;
    }
}
