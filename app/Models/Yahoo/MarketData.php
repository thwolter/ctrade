<?php
/**
 * This class provides a wrapper for the Yahoo Api functions with caching.
 *
 * The class is initialized with the name of the symbol, e.g. 'ALV.DE' or 'EURUSD'.
 * The public function 'getData' delivers the cached array from Yahoo Api request.
 */

namespace App\Models\Yahoo;

use Illuminate\Support\Facades\Cache;
use Scheb\YahooFinanceApi\ApiClient;
use App\Repositaries\Contracts\FinanceData;


abstract class MarketData implements FinanceData
{

    protected $client;
    protected $symbol;

    protected $cacheTime = 10;


    public $LastTradePrice;
    public $Currency;
    public $Name;

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
}