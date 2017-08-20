<?php

namespace App\Repositories\DataProvider;

use App\Entities\Datasource;
use App\Events\PriceData\FetchingFailed;
use App\Repositories\Contracts\DataInterface;
use App\Repositories\Exceptions\PriceDataException;
use App\Models\PriceHistory;
use Illuminate\Support\Facades\Log;

class QuandlPriceData implements DataInterface
{

    protected $priceColumnNames = ['Last', 'Close'];

    protected $datasource;
    protected $client;
    protected $length;


    public function __construct(Datasource $datasource)
    {
        $this->datasource = $datasource;

        $this->length = env('LENGTH_HISTORIC_PRICE', 500);
        $this->client = new \Quandl(env('QUANDL_API_KEY'), 'json');
    }


    public function price()
    {
        return $this->fetchHistory()->price();
    }


    public function history($dates = null)
    {
        return $this->fetchHistory()->history($dates);
    }


    private function fetchHistory()
    {
        $key = $this->datasource->dataset->code;
        $tags = [$this->datasource->provider->code, $this->datasource->database->code];

        Log::debug(sprintf('Check cache for %s from %s', $key, implode(', ', $tags)));
        $history = \Cache::tags($tags)->get($key);

        if (!$history) {

            Log::debug(sprintf('Fetching %s from %s', $key, implode(', ', $tags)));
            $json = $this->client->getSymbol($this->symbol($this->datasource), ['limit' => $this->length]);

            if ($this->client->error) {
                event(new FetchingFailed($this->datasource, $this->client->last_url, $this->client->error));
                throw new PriceDataException($this->client->error);
            }

            $item = array_get(json_decode($json, true), 'dataset');

            $prices = array_get($item, 'data');
            $column = $this->priceColumn(array_get($item, 'column_names'));

            $history = new PriceHistory($prices, $column);

            Log::debug(sprintf('Caching %s from %s', $key, implode(', ', $tags)));
            \Cache::tags($tags)->forever($key, $history);
        }

        return $history;
    }


    private function priceColumn($columnNames)
    {
        $i = 0;
        $count = count($this->priceColumnNames);

        while (!isset($column) and $i < $count) {
            $column = array_search($this->priceColumnNames[$i++], $columnNames);
        }

        return ($column) ? $column : 1;
    }


    /**
     * Get the symbol used as identifier for a data item in Quandl api.
     *
     * @return string
     */
    private function symbol()
    {
        return sprintf('%s/%s', $this->datasource->database->code, $this->datasource->dataset->code);
    }

}