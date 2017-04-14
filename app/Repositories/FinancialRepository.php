<?php

namespace App\Repositories;



class FinancialRepository
{

    protected $stockFinancial = 'App\Repositories\Yahoo\StockFinancial';
    protected $fxFinancial    = 'App\Repositories\Yahoo\FxFinancial';

    protected $instrument;
    protected $attributes;


    public function __construct($type, $attributes) {

        $this->attributes = $attributes;
        $this->makeInstrument($type);
    }


    static public function make($type, $attributes) {

        return new FinancialRepository($type, $attributes);
    }


    private function makeInstrument($type) {

        switch ($type) {

            case 'Stock': $this->instrument = $this->stockFinancial::make($this->attributes); break;
            case 'Fx':    $this->instrument = $this->fxFinancial::make($this->attributes); break;
        }

        return $this;
    }


    public function price() {

        return $this->instrument->price();

    }

    public function summary() {

        return $this->instrument->summary();

    }

    public function name() {

        return $this->instrument->name();
    }

    public function currency() {

        return $this->instrument->currency();
    }

}