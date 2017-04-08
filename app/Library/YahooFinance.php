<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 08.04.17
 * Time: 19:35
 */

namespace App\Library;


class YahooFinance
{

    protected $client;
    protected $quotes;

    public function __construct($symbol) {

        $this->client = new \Scheb\YahooFinanceApi\ApiClient();
        $this->quotes = $this->client->getQuotes($symbol);

    }

    /**
     * @return array
     */
    public function quotesArray() {

        return $this->quotes['query']['results']['quote'];

    }

    /**
     * @param string $id
     * @return mixed
     */
    public function value($id) {

        return $this->quotesArray()[$id];

    }

    /**
     * @return mixed
     */
    public function price() {

        return $this->value('LastTradePriceOnly');

    }

    public function currency() {

        return $this->value('Currency');

    }

    public function name() {

        return $this->value('Name');

    }


}