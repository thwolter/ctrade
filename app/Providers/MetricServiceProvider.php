<?php

namespace App\Providers;

use App\Exceptions\MetricServiceException;
use App\Services\MetricServices\AssetMetricService;
use App\Services\MetricServices\LimitMetricService;
use App\Services\MetricServices\MetricService;
use App\Services\MetricServices\PortfolioMetricService;
use App\Services\MetricServices\StockMetricService;
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

            $service = $this->getServiceClass(array_first($parameter));

            return new $service;
        });

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('stockMetricService', StockMetricService::class);
        $this->app->bind('assetMetricService', AssetMetricService::class);
        $this->app->bind('portfolioMetricService', PortfolioMetricService::class);
        $this->app->bind('limitMetricService', LimitMetricService::class);
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
