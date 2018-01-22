<?php

namespace App\Classes\DataProvider;

use App\Classes\TimeSeries;
use App\Contracts\DataServiceInterface;
use App\Entities\Datasource;
use App\Events\PriceData\FetchingFailed;
use App\Exceptions\DataServiceException;
use Illuminate\Support\Facades\Cache;


class QuandlPriceData implements DataServiceInterface
{

    protected $datasource;

    protected $client;

    protected $fields = [
        'data' => 'dataset.data',
        'columns' => 'dataset.column_names',
        'exchange' => 'exchange'
    ];


    public function __construct(Datasource $datasource)
    {
        $this->datasource = $datasource;
        $this->client = app()->make('QuandlClient');
    }


    /**
     * @return TimeSeries
     */
    public function history()
    {
        $item = json_decode($this->getJson(), true);

        $data = array_get($item, $this->fields['data']);
        $columns = array_get($item, $this->fields['columns']);

        return new TimeSeries($data, $this->mapColumns($columns));
    }


    private function mapColumns($columns)
    {
        $class = 'App\Classes\Metadata\Quandl\Quandl' . $this->datasource->database->code;

        $mapping = (new $class)->columns;

        foreach ($columns as $key => $value) {
            $mappedKey = array_search($value, $mapping, true);
            if ($mappedKey) $columns[$key] = $mappedKey;
        }

        return $columns;
    }


//Todo: replace this function in ApiStockController

    /**
     * Returns an nested array with column names and prices history.
     *
     * @param $attributes
     * @return array
     */
    public function dataHistory($attributes)
    {
        $item = json_decode($this->getJson(), true);

        return $this->timeSeries($item, $attributes);
    }


    protected function getJson()
    {
        return Cache::rememberForever($this->cacheKey(), function () {

            \Log::debug(sprintf('Fetching %s', $this->cacheKey()));

            $json = $this->getSymbol();
            $this->checkFetchingError();

            return $json;
        });
    }


    private function cacheKey()
    {
        return $this->datasource->cacheKey('getSymbol');
    }


    /**
     * @return bool|mixed|string
     */
    private function getSymbol()
    {
        return $this->client->getSymbol(
            $this->symbol($this->datasource), ['limit' => config('quandl.length')]
        );
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
     * @throws DataServiceException
     */
    private function checkFetchingError()
    {
        if ($this->client->error) {
            event(new FetchingFailed($this->datasource, $this->client->last_url, $this->client->error));
            throw new DataServiceException($this->client->error);
        }
    }
}