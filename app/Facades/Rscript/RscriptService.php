<?php


namespace App\Facades\Rscript;

use Illuminate\Support\Facades\Facade;


class RscriptService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'rscriptService';
    }
}