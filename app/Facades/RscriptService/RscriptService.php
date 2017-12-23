<?php


namespace App\Facades\RscriptService;

use Illuminate\Support\Facades\Facade;


class RscriptService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'rscriptService';
    }
}