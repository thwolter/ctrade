<?php

namespace App\Repositories\Yahoo;

class PortfolioFinancial extends BaseFinancial
{
    
    public function history($curreny, $from, $to)
    {
        $json = OandaFinancial::history()->get($symbol);
               
    }
}
    
                
                