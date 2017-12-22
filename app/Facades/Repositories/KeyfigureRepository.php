<?php

namespace App\Facades\Repositories;


use Illuminate\Support\Facades\Facade;

class KeyfigureRepository extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'keyfigureRepository';
    }
}