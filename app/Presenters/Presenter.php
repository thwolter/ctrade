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


    public function priceFormat($value, $currencyCode)
    {
        if (is_null($this->priceFormat)) {
            $this->priceFormat = new \NumberFormatter('de_DE', \NumberFormatter::CURRENCY);
        }

        if (is_array($value)) $value = array_first($value);
        $currencyFmt = $this->priceFormat->formatCurrency($value, $currencyCode);

        //return preg_replace($this->replace, '', $currencyFmt).' '.$currencyCode;
        return $currencyFmt;
    }

    public function price()
    {
        return $this->priceFormat($this->entity->price(), $this->entity->currencyCode());
    }

    public function valueAtRisk()
    {
        return $this->priceFormat($this->entity->valueAtRisk(), $this->entity->currencyCode());
    }

    public function percentRisk()
    {
        return sprintf('%01.1f%%', $this->entity->percentRisk());
    }

    public function priceDate()
    {
        return Carbon::parse(key($this->entity->price()))->formatLocalized('%d.%m.%Y');
    }
}