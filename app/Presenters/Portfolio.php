<?php

namespace App\Presenters;


class Portfolio extends Presenter
{

    public function cash()
    {
        return $this->priceFormat($this->entity->cash, $this->currency);
    }

    public function total()
    {
        return $this->priceFormat($this->entity->total(), $this->currency);
    }

}