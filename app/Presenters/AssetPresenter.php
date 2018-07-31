<?php

namespace App\Presenters;


use App\Classes\Output\Percent;
use App\Classes\Output\Price;
use App\Facades\AssetService;

class AssetPresenter extends Presenter
{

    private $types = [
        'Stock' => 'Aktie'
    ];


    public function name()
    {
        return $this->entity->name;
    }


    public function isin()
    {
        return $this->position()->isin;
    }


    private function position()
    {
        return $this->entity->positionable;
    }


    public function wkn()
    {
        return $this->position()->wkn;
    }


    public function convertedYieldPercent()
    {
        return new Percent(now(), AssetService::convertedYieldPercent($this->entity, now()));
    }


    public function yieldPercent()
    {
        return new Percent(now(), AssetService::yieldPercent($this->entity, now()));

    }


    public function convertedYieldPeriodPercent()
    {

    }


    public function yieldPeriodPercent()
    {

    }


    public function costValue()
    {
        return new Price(null, $this->entity->settlement, $this->entity->currency);
    }


    public function investment()
    {
        return $this->metrics->investment($this->entity)->formatValue();
    }


    public function deltaPosition($count = 1)
    {
        return $this->position()->present()->periodDelta($this->entity->exchange, $count);
    }

    public function exchange()
    {
        return $this->entity->exchange;
    }

    public function returnAbsolute()
    {
        return $this->metrics->returnAbsolute($this->entity)->formatValue();
    }


    public function type()
    {
        return array_get($this->types, $this->entity->positionable->type());
    }

    public function amount()
    {
        return $this->entity->amount;
    }

    public function price()
    {
        return $this->position()->present()->price();
    }

    public function priceDate()
    {
        return $this->position()->present()->priceDate();
    }

    public function return()
    {
        return 0;
    }

    public function value($currency = null)
    {
        return $this->metrics->value($this->entity, $currency)->formatValue();
    }

    public function risk()
    {
        return $this->metrics->risk($this->entity)->formatValue();
    }

    public function riskToValueRatio()
    {
        return $this->metrics->riskToValueRatio($this->entity)->formatValue();
    }
}