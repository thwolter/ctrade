<?php


namespace App\Presenters;


use Carbon\Carbon;

abstract class Presenter
{

    public $entity;

    protected $replace = '/[^0-9,"."]/';

    protected $priceFormat;


    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    public function __get($property)
    {
        if (method_exists($this, $property)) {

            return $this->$property();
        }

        return $this->entity->$property();
    }


    public function formatPrice($value, $currencyCode)
    {
        if (! $this->priceFormat) {
            $this->priceFormat = new \NumberFormatter('de_DE', \NumberFormatter::CURRENCY);
        }

        $value = is_array($value) ? array_first($value) : $value;
        return $value ? $this->priceFormat->formatCurrency($value, $currencyCode) : null;
    }

    public function formatPercentage($value)
    {
        return sprintf('%01.1f %%', $value);
    }



    public function valueAtRisk()
    {
        return $this->formatPrice($this->entity->valueAtRisk(), $this->entity->currency->code);
    }

    public function percentRisk()
    {
        return sprintf('%01.1f%%', $this->entity->percentRisk());
    }


    public function formatDate($date)
    {
        if ($date) {
            return Carbon::parse($date)->formatLocalized('%d.%m.%Y');
        }
    }
}