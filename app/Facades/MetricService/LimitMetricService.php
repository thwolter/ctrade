<?php

namespace App\Facades\MetricService;


use Illuminate\Support\Facades\Facade;


class LimitMetricService extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'limitMetricService';
    }
}