<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 13.04.17
 * Time: 11:48
 */

namespace App\Library\Yahoo;


class StockFinance extends FinanceData
{

    public function summary($symbol)
    {
        // TODO: Implement summary() method.
    }

    public function price($symbol)
    {
        return $this->getData('getQuotes', $symbol)['query']['results']['quote']['LastTradePriceOnly'];
    }
}