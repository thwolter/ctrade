<?php

namespace App\Classes\DataProvider;

use App\Classes\TimeSeries;
use App\Contracts\DataServiceInterface;
use App\Entities\Datasource;
use App\Events\PriceData\FetchingFailed;
use App\Exceptions\DataServiceException;


class QuandlPriceData implements DataServiceInterface
{

    protected $datasource;

    protected $client;

    protected $fields = [
        'data'      => 'dataset.data',
        'columns'   => 'dataset.column_names',
        'exchange'  => 'exchange'
    ];
    

    public function __construct(Datasource $datasource)
    {
        $this->datasource = $datasource;
        $this->client = app()->make('QuandlClient');
    }


    /**
     * @return TimeSeries
     * @throws DataServiceException
     */
    public function history()
    {
        $item = json_decode($this->getJson(), true);

        $data = array_get($item, $this->fields['data']);
        $columns = array_get($item, $this->fields['columns']);

        return new TimeSeries($data, $columns);
    }


//Todo: replace this function in ApiStockController
    /**
     * Returns an nested array with column names and prices history.
     *
     * @param $attributes
     * @return array
     * @throws DataServiceException
     */
    public function dataHistory($attributes)
    {
        $item = json_decode($this->getJson(), true);

        return $this->timeSeries($item, $attributes);
    }


    /**
     * Get the symbol used as identifier for a data item in Quandl api.
     *
     * @return string
     */
    protected function symbol()
    {
        return sprintf('%s/%s', $this->datasource->database->code, $this->datasource->dataset->code);
    }


    /**
     * Receive the tags for caching a dataset.
     *
     * @return array
     */
    protected function getTags()
    {
        return [$this->datasource->provider->code, $this->datasource->database->code];
    }


    /**
     * Get the json representation of Quandl data for an item.
     *
     * @return string
     * @throws DataServiceException
     */
    protected function getJson()
    {
        \Log::debug(sprintf('Check cache for %s from %s', $this->getKey(), implode(', ', $this->getTags())));
        $json = \Cache::tags($this->getTags())->get($this->getKey());

        if (!$json) {
            \Log::debug(sprintf('Caching %s from %s', $this->getKey(), implode(', ', $this->getTags())));

            $json = $this->fetchFromQuandl();
            \Cache::tags($this->getTags())->forever($this->getKey(), $json);
        }
        return $json;
    }


    /**
     * Fetch json data for given symbol from Quandl API.
     *
     * @return string
     * @throws DataServiceException
     */
    protected function fetchFromQuandl()
    {
        \Log::debug(sprintf('Fetching %s from %s', $this->getKey(), implode(', ', $this->getTags())));

        $json = $this->client->getSymbol(
            $this->symbol($this->datasource), ['limit' => config('quandl.length')]
        );

        if ($this->client->error) {
            event(new FetchingFailed($this->datasource, $this->client->last_url, $this->client->error));
            throw new DataServiceException($this->client->error);
        }
        return $json;
    }


    protected function getKey()
    {
        return $this->datasource->dataset->code;
    }
}