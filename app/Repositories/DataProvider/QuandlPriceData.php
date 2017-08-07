<?php

namespace App\Repositories\DataProvider;

use App\Entities\Datasource;
use App\Repositories\Contracts\DataInterface;
use App\Repositories\Exceptions\PriceDataException;
use App\Models\PriceHistory;

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


    public function history()
    {
        return $this->fetchHistory()->history();
    }


    private function fetchHistory()
    {
        $key = $this->symbol($this->datasource);
        $tags = [$this->datasource->provider->code, $this->datasource->database->code];

        $data = \Cache::tags($tags)->get($key);

        if (!$data) {
            $json = $this->client->getSymbol($this->symbol($this->datasource), ['limit' => $this->length]);

            if (!is_null($this->client->error))
                throw new PriceDataException($this->client->error);

            $array = json_decode($json, true);

            $prices = array_get($array, 'dataset.data');
            $column = $this->priceColumn(array_get($array, 'dataset.column_names'));

            $data = new PriceHistory($prices, $column);

            \Cache::tags($tags)->forever($key, $data);
        }
        
        return $data;
    }


    private function priceColumn($columnNames)
    {
        $i = 0;
        $count = count($this->priceColumnNames);

        while (! isset($column) and $i < $count) {
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