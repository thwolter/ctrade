<?php

namespace App\Presenters;


use App\Entities\Currency;

class Position extends Presenter
{

    public function price()
    {
        return $this->priceFormat($this->entity->price(), $this->entity->currencyCode());
    }
    

    public function total($currencyCode = null)
    {
        if (is_null($currencyCode)) {
            return $this->priceFormat($this->entity->total(), $this->entity->currencyCode());
        } else {
            return $this->priceFormat($this->entity->total($currencyCode), $currencyCode);
        }
    }
}