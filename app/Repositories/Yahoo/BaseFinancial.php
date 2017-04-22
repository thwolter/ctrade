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
    
    /*
     * Perhaps this function will not be required as
     * directly implemented within R code using quantmod package
     *
    public function makeHistory($symbol) {
        
        $period = (is_null($this->period)) ? 250 : $this->period;
        
        $endDate = (is_null($this->startDate)) ? Carbon::today(): $this->startDate;
        $startDate = $endDate->copy()->addDay(-$period);
        
        $directory = 'Histories/'.$endDate->toDateString();
        $filename  = "{$directory}/{$symbol}_{$period}.json";
       
       
        if (! Storage::disk('local')->exists($filename)) {
       
            $data = $this->client->getHistoricalData($symbol, $startDate, $endDate);
           
            Storage::makeDirectory($directory);
            Storage::disk('local')->put($filename, json_encode($data));
        }
       
        return $filename;
    }
    */
    
    
    
}