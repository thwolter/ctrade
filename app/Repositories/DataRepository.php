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


    public function price($date = null)
    {
        return $this->provider()->price($date);
    }


    public function history($dates = null)
    {
        return $this->provider()->history($dates);
    }


    public function allDataHistory($attributes)
    {
        return $this->provider()->allDataHistory($attributes);
    }


    private function provider()
    {
        return app($this->datasource->provider->code.'PriceData', [$this->datasource]);
    }
}