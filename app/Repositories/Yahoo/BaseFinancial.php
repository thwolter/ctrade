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


abstract class BaseFinancial implements FinanceInterface {


    protected $client;

    protected $instrument;

    protected $cacheTime = 10;

    protected $attributes;


    /**
     * MarketData constructor.
     *
     * @param $symbol
     */
    public function __construct(Array $attributes) {

        $this->client = new ApiClient();
        $this->attributes = $attributes;
    }


    abstract static public function make($attributes);


    public function __get($name)
    {
        if (array_key_exists($name, $this->attributes))
            return $this->attributes[$name];
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
}