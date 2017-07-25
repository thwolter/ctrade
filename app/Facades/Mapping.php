<?php


namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class Mapping extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mapping';
    }
}