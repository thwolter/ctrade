<?php


namespace App\Repositories\Yahoo;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;


class Financial extends YahooFinancial
{

    
    static public function history()
    {
        return new Financial;
    }
    
    
    public function get($symbol)
    {

        $period = (is_null($this->period)) ? 250 : $this->period;

        $endDate = (is_null($this->startDate)) ? Carbon::today() : $this->startDate;
        $startDate = $endDate->copy()->addDay(-$period);

      
        if (Cache::has($symbol)) {

            $json = Cache::get($symbol);
        } else {

            $data = $this->client->getHistoricalData($symbol, $startDate, $endDate);
            $json = json_encode($data['query']['results']['quote'], JSON_NUMERIC_CHECK);
            Cache::put($symbol, $json, $this->cacheHist);
        }

    
        return $json;
    }
    
    
    
    
    public function price($symbol)
    {
        return null;
    }



    public function name($symbol) {

        return null;
    }



    public function currency($symbol) {

        return null;
    }



    public function type($symbol = null)
    {
       return null;
    }
    
}