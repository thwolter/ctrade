<?php

namespace App\Facades\MetricService;


use Illuminate\Support\Facades\Facade;


class AssetMetricService extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'assetMetricService';
    }
}