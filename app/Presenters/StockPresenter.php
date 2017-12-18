<?php


namespace App\Presenters;


use App\Services\DataService;
use App\Services\MetricServices\StockMetricService;
use Carbon\Carbon;

class StockPresenter extends Presenter
{


    public function isin()
    {
        return $this->entity->isin;
    }


    public function price($exchange = null)
    {
        return $this->formatPrice(
            $this->metric->price($exchange)
        );
    }


    public function priceDate($exchange = null)
    {
        return $this->formatDate(
            key($this->metric->price($exchange))
        );
    }


    public function previousPrice($exchange = null)
    {
        return $this->formatPrice(
            $this->metric->previousPrice($exchange)
        );
    }


    public function lowPrice($exchange)
    {
        return $this->formatPrice(
            $this->metric->lowPrice($exchange)
        );
    }

    public function HighPrice($exchange)
    {
        return $this->formatPrice(
            $this->metric->highPrice($exchange)
        );
    }


    public function periodLow($exchange, $count)
    {
        return $this->formatPrice(
            $this->metric->periodHigh($exchange, $count)
        );
    }


    public function periodHigh($exchange, $count)
    {
        return $this->formatPrice(
            $this->metric->periodHigh($exchange, $count)
        );
    }


    public function periodReturn($exchange, $count)
    {
       return $this->formatPercentage(
           $this->metric->periodReturn($exchange, $count)
       );
    }



   /* public function risk()
    {
        return $this->formatPrice($this->entity->price(), $this->entity->currency->code);
    }*/

}