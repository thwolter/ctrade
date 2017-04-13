<?php
/**
 * @purpose
 *
 *
 *
 */

namespace App;

use App\Library\StockRepository;
use App\Library\Yahoo\FxData;
use App\Library\Yahoo\StockData;

class Stock extends Instrument
{
    protected $fillable = [
        'symbol',
        'currency'
    ];

    protected $stockData;

    protected $data;


    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->data = new StockRepository($this->symbol);
    }

    /**
     * Initialize new StockData Instance with provided 'symbol'
     *
     * @param string $value
     */
    public function setSymbolAttribute($value) {

        $this->stockData = new StockData($value);
        $this->attributes['symbol'] = $value;
    }


    /**
     * Provide an quotes array of existing of new YahooApi instance
     *
     * @return StockData
     */
    private function stockData() {

        if (is_null($this->stockData)) $this->stockData = new StockData($this->symbol);
        return $this->stockData;
    }

    /**
     * Return the stock's price from quotes
     *
     * @return string
     */
    public function price()
    {
        $this->data = new StockRepository($this->symbol);
        return dd($this);

        return $this->data->price();
    }


    /**
     * Returns the stock's currency from quotes
     *
     * @return string
     */
    public function currency()
    {
        return $this->stockData()->Currency;
    }


    /**
     *
     */
    public function delta()
    {
        // TODO: Implement delta() method.
    }


    /**
     * Return the stock's name from quotes
     *
     * @return string
     */
    public function name()
    {
        return $this->stockData()->Name;

    }
}
