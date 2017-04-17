<?php

namespace App\Repositories;



use App\Repositories\Yahoo\Exceptions\InvalidInstrumentType;

class FinancialRepository
{

    protected $types = [
        'S' => 'Stock',
        'C' => 'Currency',
        'I' => 'Index',
        'E' => 'ETF',
    ];

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

        $type = $this->mapType($type);

        switch ($type) {

            case 'Stock': $this->instrument = $this->stockFinancial::make($attributes); break;
            case 'Currency':    $this->instrument = $this->currencyFinancial::make($attributes); break;
        }

        return $this;
    }


    public function mapType($type)
    {
        $type = strtoupper(substr($type, 0, 1));

        if (array_key_exists($type, $this->types)) return $this->types[$type];

        throw new InvalidInstrumentType;
    }



    public function __get($name) {

        return $this->instrument->$name();
    }
}