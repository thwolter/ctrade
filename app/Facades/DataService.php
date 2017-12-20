<?php

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class DataService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'dataService';
    }
}