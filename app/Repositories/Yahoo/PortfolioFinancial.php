<?php

namespace App\Repositories\Yahoo;

use Carbon\Carbon;
use App\Repositories\Oanda\OandaFinancial;
use Illuminate\Support\Facades\Cache;

class PortfolioFinancial
{

    protected $cacheHist = 20;

    
    public function history($symbol, $from = null, $to = null)
    {
        $to = (is_null($to)) ? Carbon::today() : $to;
        $from = (is_null($from)) ? Carbon::today()->addDay(-250) : $from;

        $key = $symbol.$from->toDateString().$to->toDateString();

        if (Cache::has($key)) {

            $json = Cache::get($key);

        } else {

            $json = OandaFinancial::make()->history($symbol, $from, $to);
            Cache::put($key, $json, $this->cacheHist);
        }

        return $json;
               
    }

}