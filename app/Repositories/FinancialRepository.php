<?php

namespace App\Repositories;



class FinancialRepository
{

    protected $stockFinancial = 'App\Repositories\Yahoo\StockFinancial';
    protected $fxFinancial    = 'App\Repositories\Yahoo\FxFinancial';

    protected $instrument;
    protected $attributes;


    public function __construct($type, $attributes) {

        $this->makeInstrument($type, $attributes);
    }


    static public function make($type, $attributes) {

        return new FinancialRepository($type, $attributes);
    }


    private function makeInstrument($type, $attributes) {

        switch ($type) {

            case 'Stock': $this->instrument = $this->stockFinancial::make($attributes); break;
            case 'Fx':    $this->instrument = $this->fxFinancial::make($attributes); break;
        }

        return $this;
    }


    public function __get($name) {

        return $this->instrument->$name();
    }
}