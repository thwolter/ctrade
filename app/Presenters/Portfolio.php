<?php

namespace App\Presenters;


class Portfolio extends Presenter
{

    public function cash()
    {
        return $this->formatPrice($this->entity->cash, $this->entity->currencyCode());
    }

    public function stockTotal()
    {
        return $this->formatPrice($this->entity->stockTotal(), $this->entity->currencyCode());
    }

    public function total()
    {
        return $this->formatPrice($this->entity->total(), $this->entity->currencyCode());
    }

    public function image()
    {
        $url = $this->entity->imageUrl;
        return (! is_null($url)) ? asset('storage/'.$url) : asset('img/portfolios/bg-1.jpg');
    }

}