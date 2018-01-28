<?php

namespace App\Jobs\Calculations;


use Carbon\Carbon;

class Joblet
{

    private $portfolio;
    private $id;

    private $calculated_at;
    private $metric;
    private $total;

    private $asset;


    public function __construct($portfolio, $metric)
    {
        $this->portfolio = $portfolio;
        $this->metric = $metric;

        $this->calculated_at = Carbon::now();
        $this->id = $this->id($metric);
    }

    protected function id()
    {
        return sprintf('Portfolio-%s:%s-%s', $this->portfolio->id, 'calculate', $this->metric);
    }

    public function __get($name)
    {
        return $this->$name;
    }


    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }


    public function setAsset($asset)
    {
        $this->asset = $asset;
        return $this;
    }
}