<?php

namespace App\Presenters;


class AssetPresenter extends Presenter
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

    public function risk()
    {
        return $this->formatPrice($this->entity->metrics()->risk(), $this->entity->currency->code);
    }


    public function riskRatio()
    {
        return $this->formatPercentage($this->entity->metrics()->riskRatio());

    }


}