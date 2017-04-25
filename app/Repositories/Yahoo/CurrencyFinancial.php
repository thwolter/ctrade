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

    
    private function getValue($label, $symbol) {

        return $this->getData('getCurrenciesExchangeRate', $symbol)['query']['results']['rate'][$label];
    }



    public function price($symbol)
    {
        return $this->getValue('Rate', $symbol);
    }


    public function name($symbol) {

        return $this->getValue('Name', $symbol);
    }


    public function type($symbol = null)
    {
        return 'Currency';
    }

    public function currency($symbol)
    {
        return substr($symbol, 3, 3);
    }
    
    
}