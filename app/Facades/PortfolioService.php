<?php

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class PortfolioService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'portfolioService';
    }
}