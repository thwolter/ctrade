<?php

namespace App\Services\MetricServices;

use App\Entities\Stock;
use Carbon\Carbon;


class StockMetricService extends MetricService
{

    public function price($exchange = null)
    {
        return $this->dataService->history($this->entity, $exchange)->count(1)->get();
    }


    public function previousPrice($exchange = null)
    {
        return array_last(
            $this->dataService->history($this->entity, $exchange)->count(2)->get()
        );
    }


    public function lowPrice($exchange)
    {
        return $this->dataService->history($this->entity, $exchange)->count(1)->getLow();
    }


    public function HighPrice($exchange)
    {
        return $this->dataService->history($this->entity, $exchange)->count(1)->getHigh();
    }

    public function risk()
    {

    }
}