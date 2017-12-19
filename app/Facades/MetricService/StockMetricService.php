<?php

namespace App\Facades\MetricService;


use Illuminate\Support\Facades\Facade;


class StockMetricService extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'stockMetricService';
    }
}