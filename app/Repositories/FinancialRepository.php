<?php

namespace App\Repositories;



class FinancialRepository
{

    protected $stockFinancial = 'App\Repositories\Yahoo\StockFinancial';
    protected $fxFinancial    = 'App\Repositories\Yahoo\FxFinancial';

    protected $instrument;
    protected $symbol;


    public function __construct($type, $symbol) {

        $this->makeInstrument($type);
        $this->symbol = $symbol;
    }


    static public function make($type, $symbol) {

        return new FinancialRepository($type, $symbol);
    }


    private function makeInstrument($type) {

        switch ($type) {

            case 'Stock': $this->instrument = resolve($this->stockFinancial); break;
            case 'Fx':    $this->instrument = resolve($this->fxFinancial); break;
        }

        return $this;
    }


    public function price() {

        return $this->instrument->price($this->symbol);

    }

    public function summary() {

        return $this->instrument->summary($this->symbol);

    }

    public function name() {

        return $this->instrument->name($this->symbol);
    }

    public function currency() {

        return $this->instrument->currency($this->symbol);
    }

}