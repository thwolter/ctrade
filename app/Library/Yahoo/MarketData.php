<?php
/**
 * This class provides a wrapper for the Yahoo Api functions with caching.
 *
 * The class is initialized with the name of the symbol, e.g. 'ALV.DE' or 'EURUSD'.
 * The public function 'getData' delivers the cached array from Yahoo Api request.
 */

namespace App\Library\Yahoo;

use App\Library\Contracts\FinanceInterface;
use Illuminate\Support\Facades\Cache;
use Scheb\YahooFinanceApi\ApiClient;


abstract class MarketData implements FinanceInterface
{

    protected $client;
    protected $symbol;

    protected $instrument;

    protected $cacheTime = 10;


    /**
     * MarketData constructor.
     *
     * @param $symbol
     */
    public function __construct($symbol) {

        $this->client = new ApiClient();
        $this->symbol = $symbol;

    }


    /**
     * Provide a cached version of Yahoo Quotes
     * @param string $fun
     * @return mixed
     */
    public function getData($fun) {

        if (Cache::has($fun.$this->symbol)) {

            $data = Cache::get($fun.$this->symbol);

        } else {

            $data = $this->client->$fun($this->symbol);
            Cache::put($fun.$this->symbol, $data, $this->cacheTime);
        }

        return $data;

    }

    public function price($symbol) {

        return $this->instrument->price($symbol);

    }

    public function summary($symbol) {

        return $this->instrument->summary($symbol);

    }

}