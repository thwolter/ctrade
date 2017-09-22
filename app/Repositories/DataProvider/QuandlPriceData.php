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

    protected $tags;
    protected $key;


    public function __construct(Datasource $datasource)
    {
        $this->datasource = $datasource;
        $this->client = app()->make('QuandlClient');

        $this->config();
    }


    public function price($date = null)
    {
        return $this->getPriceHistory()->price($date);
    }


    /**
     * Return an array with the history of close prices of an item.
     *
     * @param array $dates
     * @return array
     */
    public function history($dates = null)
    {
        return $this->getPriceHistory()->history($dates);
    }

    /**
     * Returns an nested array with column names and prices history.
     *
     * @param array $attributes
     * @return array
     */
    public function allDataHistory($attributes)
    {
        $item = json_decode($this->getJson(), true);

        if (array_has($attributes, ['from', 'to'])) {
            $data = $this->getTimeSeriesFromTo($item, $attributes['from'], $attributes['to']);

        } elseif (array_has($attributes, ['date', 'count'])) {
            $data = $this->getTimeSeriesDateCount($item, $attributes['date'], $attributes['count']);

        } else {
            $data = $this->getTimeSeries($item);
        }

        return [
            'columns' => $this->getColumnNames($item),
            'data' => $data
        ];
    }


    private function getPriceHistory()
    {
        $data = json_decode($this->getJson(), true);

        $prices = array_get($data, 'dataset.data');
        $columns = array_get($data, 'dataset.column_names');

        return new PriceHistory($prices, $this->priceColumn($columns));
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


    /**
     * Receive the tags for caching a dataset.
     *
     * @return array
     */
    private function getTags()
    {
        return [$this->datasource->provider->code, $this->datasource->database->code];
    }


    /**
     * Get the json representation of Quandl data for an item.
     *
     * @return string
     */
    private function getJson()
    {
        Log::debug(sprintf('Check cache for %s from %s', $this->key, implode(', ', $this->tags)));
        $json = \Cache::tags($this->tags)->get($this->key);

        if (!$json) {
            Log::debug(sprintf('Caching %s from %s', $this->key, implode(', ', $this->tags)));

            $json = $this->fetchFromQuandl();
            \Cache::tags($this->tags)->forever($this->key, $json);
        }
        return $json;
    }


    /**
     * Fetch json data for given symbol from Quandl API.
     *
     * @return string
     * @throws PriceDataException
     */
    private function fetchFromQuandl()
    {
        Log::debug(sprintf('Fetching %s from %s', $this->key, implode(', ', $this->tags)));
        $json = $this->client->getSymbol($this->symbol($this->datasource), ['limit' => $this->length]);

        if ($this->client->error) {
            event(new FetchingFailed($this->datasource, $this->client->last_url, $this->client->error));
            throw new PriceDataException($this->client->error);
        }
        return $json;
    }

    /**
     * Set the required configuration for the Datasource and Quandl Api.
     *
     */
    private function config()
    {
        $this->length = config('quandl.length');

        $this->key = $this->datasource->dataset->code;
        $this->tags = $this->getTags();
    }

    /**
     * Returns data between a given period.
     *
     * @param array $rawdata
     * @param $from
     * @param $to
     * @return array
     */
    private function getTimeSeriesFromTo($item, $from, $to)
    {
        $timeSeries = $this->getTimeSeries($item);

        return array_where($timeSeries, function ($value) use ($from, $to) {
            return $value[0] >= $from && $value[0] <= $to;
        });
    }


    private function getTimeSeriesDateCount($item, $date, $count)
    {
        $timeSeries = $this->getTimeSeries($item);

        $result = array_where($timeSeries, function ($value) use ($date) {
            return $value[0] <= $date;
        });

        return array_slice($result, 0, $count);
    }


    /**
     * @param $item
     * @return mixed
     */
    private function getTimeSeries($item)
    {
        return array_get($item, 'dataset.data');
    }

    /**
     * @param $item
     * @return mixed
     */
    private function getColumnNames($item)
    {
        $columns = array_get($item, 'dataset.column_names');
        return $columns;
    }

}