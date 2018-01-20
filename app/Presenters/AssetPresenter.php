<?php

namespace App\Presenters;



class AssetPresenter extends Presenter
{

    private $types = [
        'Stock' => 'Aktie'
    ];

    public function name()
    {
        return $this->entity->name;
    }

    public function isin()
    {
        return $this->position()->isin;
    }

    public function wkn()
    {
        return $this->position()->wkn;
    }

    public function cost()
    {
        return $this->metrics->cost($this->entity)->formatValue();
    }

    public function investment()
    {
        return $this->metrics->investment($this->entity)->formatValue();
    }

    public function deltaPosition($count = 1)
    {
        return $this->position()->present()->periodDelta($this->entity->exchange, $count);
    }

    public function exchange()
    {
        return $this->entity->exchange;
    }

    public function returnAbsolute()
    {
        return $this->metrics->returnAbsolute($this->entity)->formatValue();
    }

    public function returnPercent()
    {
        return $this->metrics->returnPercent($this->entity)->formatValue();
    }

    public function type()
    {
        return array_get($this->types, $this->entity->positionable->type());
    }

    /**
     * Return the asset's amount.
     *
     * @return mixed
     */
    public function amount()
    {
        return $this->entity->amount;
    }

    public function price()
    {
        return $this->position()->present()->price();
    }


    public function priceDate()
    {
        return $this->position()->present()->priceDate();
    }

    public function return()
    {
        return 0;
    }


    /**
     * Return the formatted asset's value.
     *
     * @param string|null $currency
     * @return string
     */
    public function value($currency = null)
    {
        return $this->metrics->value($this->entity, $currency)->formatValue();
    }


    /**
     * Return the formatted asset's risk.
     *
     * @return string
     */
    public function risk()
    {
        return $this->metrics->risk($this->entity)->formatValue();
    }


    /**
     * Return the formatted asset's risk to value ratio.
     *
     * @return string
     */
    public function riskToValueRatio()
    {
        return $this->metrics->riskToValueRatio($this->entity)->formatValue();
    }

    /**
     * @return mixed
     */
    private function position()
    {
        return $this->entity->positionable;
    }
}