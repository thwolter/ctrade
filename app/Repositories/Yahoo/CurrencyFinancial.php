<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 13.04.17
 * Time: 11:48
 */

namespace App\Repositories\Yahoo;


class CurrencyFinancial extends BaseFinancial
{

    static public function make($attributes) {

        return new CurrencyFinancial($attributes);
    }

    private function getValue($label, $symbol) {

        return $this->getData('getCurrenciesExchangeRate', $symbol)['query']['results']['rate'][$label];
    }

    public function summary()
    {
        // TODO: Implement summary() method.
    }

    public function price()
    {
        return $this->getValue('Rate', $this->symbol);
    }


    public function name() {

        return $this->getValue('Name', $this->symbol);
    }

    public function symbol()
    {
        return $this->symbol;
    }

    public function type()
    {
        return 'Currency';
    }

    public function currency()
    {
        return substr($this->symbol, 0, 3);
    }
}