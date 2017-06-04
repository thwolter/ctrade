<?php

namespace App\Presenters;


class Portfolio extends Presenter
{

    public function cash()
    {
        return $this->priceFormat($this->entity->cash, $this->entity->currencyCode());
    }

    public function stockTotal()
    {
        return $this->priceFormat($this->entity->stockTotal(), $this->entity->currencyCode());
    }

    public function total()
    {
        return $this->priceFormat($this->entity->total(), $this->entity->currencyCode());
    }

}