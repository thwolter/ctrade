<?php

namespace App\Facades\Repositories;


use Illuminate\Support\Facades\Facade;


class DatasourceRepository extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'datasourceRepository';
    }
}