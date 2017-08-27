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
        if (is_null($this->priceFormat)) {
            $this->priceFormat = new \NumberFormatter('de_DE', \NumberFormatter::CURRENCY);
        }

        if (is_array($value)) $value = array_first($value);
        $currencyFmt = $this->priceFormat->formatCurrency($value, $currencyCode);

        //return preg_replace($this->replace, '', $currencyFmt).' '.$currencyCode;
        return $currencyFmt;
    }

    public function formatPercentage($value)
    {
        return sprintf('%01.1f %%', $value);
    }

    public function price()
    {
        return $this->formatPrice($this->entity->price(), $this->entity->currencyCode());
    }

    public function valueAtRisk()
    {
        return $this->formatPrice($this->entity->valueAtRisk(), $this->entity->currencyCode());
    }

    public function percentRisk()
    {
        return sprintf('%01.1f%%', $this->entity->percentRisk());
    }

    public function priceDate()
    {
        return Carbon::parse(key($this->entity->price()))->formatLocalized('%d.%m.%Y');
    }

    public function formatDate($date)
    {
        if ($date) {
            return Carbon::parse($date)->formatLocalized('%d.%m.%Y');
        }
    }
}