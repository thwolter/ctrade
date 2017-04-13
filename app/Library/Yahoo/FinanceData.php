<?php
/**
 * This class provides a wrapper for the Yahoo Api functions with caching.
 *
 * The class is initialized with the name of the symbol, e.g. 'ALV.DE' or 'EURUSD'.
 * The public function 'getData' delivers the cached array from Yahoo Api request.
 */

namespace App\Library\Yahoo;


use Illuminate\Support\Facades\Cache;
use Scheb\YahooFinanceApi\ApiClient;
use App\Library\Contracts\FinanceInterface;


abstract class FinanceData implements FinanceInterface {


    protected $client;

    protected $instrument;

    protected $cacheTime = 10;


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
    public function getData($fun, $symbol) {

        if (Cache::has($fun.$symbol)) {

            $data = Cache::get($fun.$symbol);

        } else {

            $data = $this->client->$fun($symbol);
            Cache::put($fun.$symbol, $data, $this->cacheTime);
        }

        return $data;

    }
}