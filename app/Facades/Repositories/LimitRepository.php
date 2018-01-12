<?php

namespace App\Facades\Repositories;


use Illuminate\Support\Facades\Facade;

class LimitRepository extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'limitRepository';
    }
}