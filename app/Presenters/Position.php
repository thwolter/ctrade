<?php

namespace App\Presenters;


class Position extends Presenter
{

    public function total($currencyCode = null)
    {
        if (is_null($currencyCode)) {
            return $this->formatPrice($this->entity->total(), $this->entity->currencyCode());
        } else {
            return $this->formatPrice($this->entity->total($currencyCode), $currencyCode);
        }
    }
}