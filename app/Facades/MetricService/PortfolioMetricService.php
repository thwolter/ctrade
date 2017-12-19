<?php

namespace App\Facades\MetricService;


use Illuminate\Support\Facades\Facade;


class PortfolioMetricService extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'portfolioMetricService';
    }
}