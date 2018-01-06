<?php

namespace App\Facades\RiskService;


use Illuminate\Support\Facades\Facade;

class RiskService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'riskService';
    }
}