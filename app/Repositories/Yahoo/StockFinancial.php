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

    private function getValue($label, $symbol) {

        return $this->getData('getQuotes', $symbol)['query']['results']['quote'][$label];
    }

    public function summary($symbol)
    {
        // TODO: Implement summary() method.
    }


    public function price($symbol)
    {
        return $this->getValue('LastTradePriceOnly', $symbol);
    }


    public function name($symbol) {

        return $this->getValue('Name', $symbol);
    }


    public function currency($symbol) {

        return $this->getValue('Currency', $symbol);
    }
}