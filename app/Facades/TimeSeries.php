<?php

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class TimeSeries extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'TimeSeries';
    }
}