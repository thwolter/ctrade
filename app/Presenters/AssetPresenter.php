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
            return $this->formatPrice($this->metrics->value($this->entity));
        } else {
            return $this->formatPrice($this->metrics->value($this->entity, $currencyCode), $currencyCode);
        }
    }


    public function risk()
    {
        return $this->formatPrice($this->metrics->risk($this->entity));
    }


    public function riskRatio()
    {
        return $this->formatPercentage($this->metrics->riskRatio($this->entity));

    }


}