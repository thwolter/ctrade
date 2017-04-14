<?php
/**
 * @purpose
 *
 *
 *
 */

namespace App;

use App\Repositories\FinancialRepository as Financial;
use App\Repositories\Yahoo\FxData;
use App\Repositories\Yahoo\StockData;

class Stock extends Instrument
{
    protected $fillable = [
        'symbol',
        'currency'
    ];



    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->financial = Financial::make('Stock', $this->symbol);
    }


    public function model() {

        $this->model = 'App\Stock';
    }

    /**
     * Return the stock's price from quotes
     *
     * @return string
     */
    public function price()
    {
        $this->financial = Financial::make('Stock', $this->symbol);

        return $this->financial->price();
    }


    /**
     * Returns the stock's currency from quotes
     *
     * @return string
     */
    public function currency()
    {

        $this->financial = Financial::make('Stock', $this->symbol);
        return $this->financial->currency();
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
        return $this->financial->name();

    }
}
