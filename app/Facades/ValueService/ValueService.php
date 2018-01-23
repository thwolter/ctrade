<?php

namespace App\Facades\ValueService;


use Illuminate\Support\Facades\Facade;

class ValueService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'valueService';
    }
}