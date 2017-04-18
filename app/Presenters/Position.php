<?php

namespace App\Presenters;


class Position extends Presenter
{

    protected $priceFormat;

    public function priceFormat()
    {
        if (is_null($this->priceFormat)) {
            $this->priceFormat = new \NumberFormatter( 'de_DE', \NumberFormatter::CURRENCY );
        }
        return $this->priceFormat;
    }


    public function price()
    {
        return $this->priceFormat()->formatCurrency($this->entity->price(), $this->currency);
    }

    public function total()
    {
        return $this->priceFormat()->formatCurrency($this->entity->total(), $this->currency);
    }

}