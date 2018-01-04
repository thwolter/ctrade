<?php

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class RiskService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'riskService';
    }
}