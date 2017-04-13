<?php

namespace App\Library\Yahoo;

use Illuminate\Container\Container as App;
use App\Library\Contracts\FinanceInterface;
use Illuminate\Support\Facades\Cache;
use Scheb\YahooFinanceApi\ApiClient;


abstract class Repository implements FinanceInterface
{
    private $app;
    protected $instrument;
    protected $ich;


    public function __construct(App $app) {

        $this->app = $app;
        $this->makeInstrument();
    }


    abstract function instrument();

    private function makeInstrument() {

        $this->instrument = $this->app->make($this->instrument());
        $this->ich = "hi";

        return $this;
    }


    public function price($symbol) {

        return $this->instrument->price($symbol);

    }

    public function summary($symbol) {

        return $this->instrument->summary($symbol);

    }

}