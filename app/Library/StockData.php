<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 08.04.17
 * Time: 19:35
 */

namespace App\Library;

use Illuminate\Support\Facades\Cache;


class StockData
{

    protected $client;
    protected $symbol;

    public function __construct($symbol) {

        $this->client = new \Scheb\YahooFinanceApi\ApiClient();
        $this->symbol = $symbol;
    }

    /**
     * @return array
     */
    public function quotes($id) {

        if (Cache::has('quotes'.$this->symbol)) {
            $quotes = Cache::get('quotes'.$this->symbol);
        } else {
            $quotes = $this->client->getQuotes($this->symbol);
            Cache::put('quotes'.$this->symbol, $quotes, 1);
        }

        return $quotes['query']['results']['quote'][$id];

    }
}