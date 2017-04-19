<?php


namespace App\Presenters;


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
    
    
    public function priceFormat($value, $currency)
    {
        if (is_null($this->priceFormat)) {
            $this->priceFormat = new \NumberFormatter( 'de_DE', \NumberFormatter::CURRENCY );
        }
        
        $currencyFmt = $this->priceFormat->formatCurrency($value, $currency);
        
        return preg_replace($this->replace, '', $currencyFmt).' '.$currency;
    
    }

}