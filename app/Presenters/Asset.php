<?php

namespace App\Presenters;


class Asset extends Presenter
{

    public function amount()
    {
        return $this->entity->amount();
    }

    public function value($currencyCode = null)
    {
        if (is_null($currencyCode)) {
            return $this->formatPrice($this->entity->value(), $this->entity->currency->code);
        } else {
            return $this->formatPrice($this->entity->value($currencyCode), $currencyCode);
        }
    }



}