<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 08.04.17
 * Time: 19:35
 */

namespace App\Library\Yahoo;


class StockData extends MarketData
{

    /**
     * Dynamically retrieve attributes on the model
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key) {

        $data = $this->getData('getQuotes')['query']['results']['quote'];

        if (array_key_exists($key, $data)) return $data[$key];
    }

    public function price($symbol) {

    }

    public function summary($symbol) {

    }
}