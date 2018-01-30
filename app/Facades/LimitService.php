<?php

namespace App\Facades;


use Illuminate\Support\Facades\Facade;


class LimitService extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'limitService';
    }
}