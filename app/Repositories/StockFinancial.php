<?php


namespace App\Repositories;

use Carbon\Carbon;
use App\Repositories\Yahoo\YahooFinancial;
use Illuminate\Support\Facades\Cache;


class StockFinancial extends YahooFinancial
{

  
    private function getValue($label, $symbol) {

        return $this->getData('getQuotes', $symbol)['query']['results']['quote'][$label];
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



    public function type($symbol = null)
    {
        return 'Stock';
    }
    
    
    public function history(String $symbol, Carbon $from = null, Carbon $to = null)
    {
        $to = (is_null($to)) ? Carbon::today() : $to;
        $from = (is_null($from)) ? Carbon::today()->addDay(-250) : $from;

        $key = $symbol.$from->toDateString().$to->toDateString();

        if (Cache::has($key)) {

            $json = Cache::get($key);

        } else {

            $data = $this->client->getHistoricalData($symbol, $from, $to);
            $json = json_encode($data['query']['results']['quote'], JSON_NUMERIC_CHECK);

            Cache::put($key, $json, $this->cacheHist);
        }
        
        return $json;
    }
}