<?php

namespace App\Repositories;



class FinancialRepository
{

    protected $stockFinancial = 'App\Repositories\Yahoo\StockFinancial';
    protected $currencyFinancial    = 'App\Repositories\Yahoo\CurrencyFinancial';

    protected $instrument;
    protected $attributes;


    public function __construct($type, Array $attributes) {

        $this->makeInstrument($type, $attributes);
    }


    static public function make($type, Array $attributes) {

        return new FinancialRepository($type, $attributes);
    }


    private function makeInstrument($type, $attributes) {

        switch ($type) {

            case 'Stock': $this->instrument = $this->stockFinancial::make($attributes); break;
            case 'Currency':    $this->instrument = $this->currencyFinancial::make($attributes); break;
        }

        return $this;
    }


    public function __get($name) {

        return $this->instrument->$name();
    }
}