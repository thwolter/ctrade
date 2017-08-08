<?php


namespace App\Observers;


use App\Entities\Datasource;
use Illuminate\Support\Facades\Cache;


class DatasourceObserver
{

    public function updated(Datasource $datasource)
    {
        Cache::forget($datasource->key());
    }
}