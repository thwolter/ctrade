<?php

namespace App\Presenters;


class Position extends Presenter
{

    public function price()
    {
        return $this->priceFormat($this->entity->price(), $this->currency);
    }
    

    public function total($currency = null)
    {
        if (is_null($currency)) {
            return $this->priceFormat($this->entity->total(), $this->currency);
        } else {
            return $this->priceFormat($this->entity->total($currency), $currency);
        }
    }
}