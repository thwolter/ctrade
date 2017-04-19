<?php

namespace App\Presenters;


class Portfolio extends Presenter
{

    public function cash()
    {
        return $this->priceFormat($this->entity->cash, $this->currency);
    }

    public function total($currency = null)
    {
        if (is_null($currency)) $currency = $this->currency;
        
        return $this->priceFormat($this->entity->total($currency), $currency);
    }

}