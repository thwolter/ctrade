<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 13.04.17
 * Time: 11:48
 */

namespace App\Repositories\Yahoo;


class FxFinancial extends BaseFinancial
{

    private function getValue($label, $symbol) {

        return $this->getData('getCurrenciesExchangeRate', $symbol)['query']['results']['rate'][$label];
    }

    public function summary($symbol)
    {
        // TODO: Implement summary() method.
    }

    public function price($symbol)
    {
        return $this->getValue('Rate', $symbol);

    }


    public function name($symbol) {

        return $this->getValue('id', $symbol);
    }
}