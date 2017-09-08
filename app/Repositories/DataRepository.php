<?php


namespace App\Repositories;

use App\Entities\Datasource;


class DataRepository
{

    protected $datasource;


    public function __construct(Datasource $datasource)
    {
        $this->datasource = $datasource;
    }


    public function price()
    {
        return $this->provider()->price();
    }


    public function history($dates = null)
    {
        return $this->provider()->history($dates);
    }


    public function rawHistory($attributes)
    {
        return $this->provider()->rawHistory($attributes);
    }


    private function provider()
    {
        return app($this->datasource->provider->code.'PriceData', [$this->datasource]);
    }
}