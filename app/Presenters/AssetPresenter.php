<?php

namespace App\Presenters;



class AssetPresenter extends Presenter
{


    /**
     * Return the asset's amount.
     *
     * @return mixed
     */
    public function amount()
    {
        return $this->entity->amount;
    }


    /**
     * Return the formatted asset's value.
     *
     * @param string|null $currency
     * @return string
     */
    public function value($currency = null)
    {
        if (is_null($currency)) {
            return $this->formatPrice($this->metrics->value($this->entity)->getValue());
        } else {
            return $this->formatPrice($this->metrics->value($this->entity, $currency)->getValue(), $currency);
        }
    }


    /**
     * Return the formatted asset's risk.
     *
     * @return string
     */
    public function risk()
    {
        return $this->metrics->risk($this->entity)->toLocalCurrencyFormat();
    }


    /**
     * Return the formatted asset's risk to value ratio.
     *
     * @return string
     */
    public function riskToValueRatio()
    {
        return $this->metrics->riskToValueRatio($this->entity)->toLocalPercentageFormat();
    }
}