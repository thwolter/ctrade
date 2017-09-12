<?php

namespace App\Presenters;


class Position extends Presenter
{

    public function sumAmount()
    {
        return $this->entity->sumAmount();
    }

    public function sumValue($currencyCode = null)
    {
        if (is_null($currencyCode)) {
            return $this->formatPrice($this->entity->sumValue(), $this->entity->currencyCode());
        } else {
            return $this->formatPrice($this->entity->sumValue($currencyCode), $currencyCode);
        }
    }



}