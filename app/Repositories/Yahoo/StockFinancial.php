<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 13.04.17
 * Time: 11:48
 */

namespace App\Repositories\Yahoo;


class StockFinancial extends BaseFinancial
{

    static public function make($attributes) {

        return new StockFinancial($attributes);
    }

    private function getValue($label, $symbol) {

        return $this->getData('getQuotes', $symbol)['query']['results']['quote'][$label];
    }

    public function summary()
    {
        // TODO: Implement summary() method.
    }


    public function price()
    {
        return $this->getValue('LastTradePriceOnly', $this->symbol);
    }


    public function name() {

        return $this->getValue('Name', $this->symbol);
    }


    public function currency() {

        return $this->getValue('Currency', $this->symbol);
    }
}