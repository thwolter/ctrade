<?php

namespace App\Facades;


use Illuminate\Support\Facades\Facade;


class PositionService extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'positionService';
    }
}