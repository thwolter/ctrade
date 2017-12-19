<?php


namespace App\Presenters;



class StockPresenter extends Presenter
{


    public function isin()
    {
        return $this->entity->isin;
    }


    public function price($exchange = null)
    {
        return $this->formatPrice(
            $this->metrics->price($this->entity, $exchange)
        );
    }


    public function priceDate($exchange = null)
    {
        return $this->formatDate(
            key($this->metrics->price($this->entity, $exchange))
        );
    }


    public function previousPrice($exchange = null)
    {
        return $this->formatPrice(
            $this->metrics->previousPrice($this->entity, $exchange)
        );
    }


    public function lowPrice($exchange)
    {
        return $this->formatPrice(
            $this->metrics->lowPrice($this->entity, $exchange)
        );
    }

    public function HighPrice($exchange)
    {
        return $this->formatPrice(
            $this->metrics->highPrice($this->entity, $exchange)
        );
    }


    public function periodLow($exchange, $count)
    {
        return $this->formatPrice(
            $this->metrics->periodHigh($this->entity, $exchange, $count)
        );
    }


    public function periodHigh($exchange, $count)
    {
        return $this->formatPrice(
            $this->metrics->periodHigh($this->entity, $exchange, $count)
        );
    }


    public function periodReturn($exchange, $count)
    {
       return $this->formatPercentage(
           $this->metrics->periodReturn($this->entity, $exchange, $count)
       );
    }



   public function risk($exchange)
    {
        return $this->formatPrice(
            $this->metrics->risk($this->entity, $exchange)
        );
    }

}