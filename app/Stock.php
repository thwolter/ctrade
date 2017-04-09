<?php
/**
 * @purpose
 *
 *
 *
 */

namespace App;

use App\Library\StockData;
use Illuminate\Database\Eloquent\Model;

class Stock extends Instrument
{
    protected $fillable = [
        'symbol',
        'currency'
    ];

    protected $stockData_instance;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

    }


    /**
     * Return the value for the requested key from stock quotes
     *
     * @param string $id
     * @return string
     */
    public function quotes($id)
    {
        if (is_null($this->stockData_instance))
            $this->stockData_instance = new StockData($this->symbol);

        return $this->stockData_instance->quotes($id);
    }


    /**
     * Return the stock's price from quotes
     *
     * @return string
     */
    public function price()
    {
        return $this->quotes('LastTradePriceOnly');
    }


    /**
     * Returns the stock's currency from quotes
     *
     * @return string
     */
    public function currency()
    {
        return $this->quotes('Currency');
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
        return $this->quotes('Name');

    }

}
