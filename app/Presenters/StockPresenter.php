<?php


namespace App\Presenters;



class StockPresenter extends Presenter
{


    public function isin()
    {
        return $this->entity->isin;
    }

    public function wkn()
    {
        return $this->entity->isin;
    }

    public function price($exchange = null)
    {
        return $this->metrics->price($this->entity, $exchange)->formatValue();
    }


    public function priceDate($exchange = null)
    {
        return $this->metrics->price($this->entity, $exchange)->formatDate();
    }


    public function previousPrice($exchange = null)
    {
        return $this->metrics->previousPrice($this->entity, $exchange)->formatValue();
    }


    public function lowPrice($exchange)
    {
        return $this->metrics->lowPrice($this->entity, $exchange)->formatValue();
    }

    public function HighPrice($exchange)
    {
        return $this->metrics->highPrice($this->entity, $exchange)->formatValue();
    }


    public function periodLow($exchange, $count)
    {
        return $this->metrics->periodLow($this->entity, $exchange, $count)->formatValue();
    }


    public function periodHigh($exchange, $count)
    {
        return $this->metrics->periodHigh($this->entity, $exchange, $count)->formatValue();
    }


    public function periodDelta($exchange, $count)
    {
        return $this->metrics->periodDelta($this->entity, $exchange, $count)->formatValue();
    }

    //todo: this should be delivered as a percentatge value
    public function periodReturn($exchange, $count)
    {
        return $this->metrics->periodReturn($this->entity, $exchange, $count)->formatValue();
    }


    public function expectedReturn($exchange)
    {
        return $this->metrics->expectedReturn($this->entity, $exchange)->formatValue();
    }

    public function expectedReturnToPrice($exchange)
    {
        return $this->metrics->expectedReturnToPrice($this->entity, $exchange)->formatValue();
    }


   public function risk()
    {
        return $this->metrics->risk($this->entity)->formatValue();
    }


    public function riskToPrice($exchange)
    {
        return $this->metrics->riskToPrice($this->entity, $exchange)->formatValue();
    }


    public function sector()
    {
        return optional($this->entity->sector)->name;
    }


    public function industry()
    {
        return optional($this->entity->industry)->name;
    }
}