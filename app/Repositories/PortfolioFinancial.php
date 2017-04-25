<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Repositories\Oanda\OandaFinancial;

class PortfolioFinancial
{
    
    public function history($symbol, $from = null, $to = null)
    {
        $to = (is_null($to)) ? Carbon::today() : $to;
        $from = (is_null($from)) ? Carbon::today()->addDay(-250) : $from;

        $json = OandaFinancial::history()->get($symbol);

        return $json;
               
    }



}
    
                
                