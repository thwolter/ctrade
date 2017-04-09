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
     * Provide a cached version of Yahoo Quotes
     *
     * @return mixed
     */
    public function quotes_array() {

        if (Cache::has('quotes'.$this->symbol)) {
            $quotes = Cache::get('quotes'.$this->symbol);
        } else {
            $quotes = $this->client->getQuotes($this->symbol);
            Cache::put('quotes'.$this->symbol, $quotes, 1);
        }

        return $quotes['query']['results']['quote'];

    }

    /**
     * Dynamically retrieve attributes on the model
     *
     * @param $key
     * @return mixed
     */
    public function __get($key) {

        if (array_key_exists($key, $this->quotes_array()))
            return $this->quotes_array()[$key];
    }
}