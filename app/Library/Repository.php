<?php

namespace App\Library;

use Illuminate\Container\Container as App;
use App\Library\Contracts\FinanceInterface;


abstract class Repository
{

    protected $instrument;
    protected $symbol;

    public function __construct($symbol = null) {

        $this->makeInstrument();
        $this->symbol = $symbol;
    }


    abstract function instrument();


    private function makeInstrument() {

        $this->instrument = resolve($this->instrument());

        return $this;
    }

    public function symbol($symbol) {

        $this->symbol = $symbol;
        return $this;
    }

    public function price() {

        return $this->instrument->price($this->symbol);

    }

    public function summary() {

        return $this->instrument->summary($this->symbol);

    }

}