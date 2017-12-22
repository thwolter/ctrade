<?php

namespace App\Facades\Repositories;


use Illuminate\Support\Facades\Facade;


class PortfolioRepository extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'portfolioRepository';
    }
}