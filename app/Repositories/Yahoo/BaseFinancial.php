<?php
/**
 * This class provides a wrapper for the Yahoo Api functions with caching.
 *
 * The class is initialized with the name of the symbol, e.g. 'ALV.DE' or 'EURUSD'.
 * The public function 'getData' delivers the cached array from Yahoo Api request.
 */

namespace App\Repositories\Yahoo;


use Illuminate\Support\Facades\Cache;
use Scheb\YahooFinanceApi\ApiClient;
use App\Repositories\Contracts\FinanceInterface;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


abstract class BaseFinancial implements FinanceInterface {


    protected $client;

    protected $instrument;

    protected $cacheTime = 10;
    protected $cacheHist = 20;

    protected $period = 250; //period in days 
    
    protected $startDate;


    /**
     * MarketData constructor.
     *
     * @param $symbol
     */
    public function __construct() {

        $this->client = new ApiClient();
    }


  
    /**
     * Provide a cached version of Yahoo Quotes
     * @param string $fun
     * @return mixed
     */
    public function getData($fun, $id) {

        if (Cache::has($fun.$id)) {

            $data = Cache::get($fun.$id);

        } else {

            $data = $this->client->$fun($id);
            Cache::put($fun.$id, $data, $this->cacheTime);
        }

        return $data;
    }
    
    
    
    public function startDate($date) {
        
        $this->startDate = new Carbon($date);
        return $this;
    }
    
    public function period($period) {
        
        $this->period = $period;
        return $this;
    }



    public function makeHistory($symbol, $directory)
    {

        $period = (is_null($this->period)) ? 250 : $this->period;

        $endDate = (is_null($this->startDate)) ? Carbon::today() : $this->startDate;
        $startDate = $endDate->copy()->addDay(-$period);

        $filename = "{$directory}/{$symbol}.json";

        if (Cache::has($symbol)) {

            $json = Cache::get($symbol);
        } else {

            $json = json_encode($this->client->getHistoricalData($symbol, $startDate, $endDate));
            Cache::put($symbol, $json, $this->cacheHist);
        }

    
        Storage::disk('local')->put($filename, $json);

        return $filename;
    }

    
    
    
}