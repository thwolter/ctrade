<?php


namespace App\Facades;

use Illuminate\Support\Facades\Facade;


class Datasource extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'datasource';
    }
}