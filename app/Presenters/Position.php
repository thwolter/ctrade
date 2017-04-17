<?php

namespace App\Presenters;


class Position extends Presenter
{


    public function price()
    {
        return $this->entity->price();
        return numfmt_format_currency($this->priceFormat(), $this->entity->price(), $this->currency);
    }

}