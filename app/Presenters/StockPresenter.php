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
        return $this->metrics->price($this->entity, $exchange)->toLocalCurrencyFormat();
    }


    public function priceDate($exchange = null)
    {
        return $this->metrics->price($this->entity, $exchange)->toLocalDateFormat();
    }


    public function previousPrice($exchange = null)
    {
        return $this->metrics->previousPrice($this->entity, $exchange)->toLocalCurrencyFormat();
    }


    public function lowPrice($exchange)
    {
        return $this->metrics->lowPrice($this->entity, $exchange)->toLocalCurrencyFormat();
    }

    public function HighPrice($exchange)
    {
        return $this->metrics->highPrice($this->entity, $exchange)->toLocalCurrencyFormat();
    }


    public function periodLow($exchange, $count)
    {
        return $this->metrics->periodLow($this->entity, $exchange, $count)->toLocalCurrencyFormat();
    }


    public function periodHigh($exchange, $count)
    {
        return $this->metrics->periodHigh($this->entity, $exchange, $count)->toLocalCurrencyFormat();
    }


    public function periodReturn($exchange, $count)
    {
        return $this->metrics->periodReturn($this->entity, $exchange, $count)->toLocalCurrencyFormat();
    }


    public function expectedReturn($exchange)
    {
        return $this->metrics->expectedReturn($this->entity, $exchange)->toLocalCurrencyFormat();
    }

    public function expectedReturnToPrice($exchange)
    {
        return $this->metrics->expectedReturnToPrice($this->entity, $exchange)->toLocalPercentageFormat();
    }

   public function risk()
    {
        return $this->metrics->risk($this->entity)->toLocalCurrencyFormat();
    }


    public function riskToPrice($exchange)
    {
        return $this->metrics->riskToPrice($this->entity, $exchange)->toLocalPercentageFormat();
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