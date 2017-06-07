<?php

namespace App\Repositories\Quandl;

use App\Entities\Database;
use App\Entities\Dataset;
use App\Models\Exceptions\QuandlException;
use App\Entities\Datasource;
use Carbon\Carbon;

class Quandldata
{

    protected $priceColumnNames = ['Last', 'Close'];

    protected $client;
    protected $source;


    /**
     * Quandldata constructor.
     * @param string $code of a dataset
     */
    public function __construct(String $code)
    {
        $this->client = new \Quandl(env('QUANDL_API_KEY'), 'json');
        $this->source = $this->getDatasource($code);
    }


    public function price()
    {
        return $this->getArrayHistory(['limit' => 1]);
    }

    /**
     * The price of an instrument with given dataset code
     * @param string $code
     * @return int
     */
    static public function getPrice($code)
    {
        $quandl = new Quandldata($code);
        return $quandl->price();
    }


    public function history($parameter = ['limit' => 250])
    {
        return $this->getArrayHistory($parameter);

    }


    /**
     * The history of an instrument with given dataset code
     * @param string $code
     * @param array $parameter
     * @return array
     */
    static public function getHistory($code, $parameter = ['limit' => 250])
    {
        $key = 'Quandl_'.$code;
        
        if (\Cache::store('database')->has($key))
            return \Cache::store('database')->get($key);
            
        $quandl = new Quandldata($code);
        $data = $quandl->history($parameter);
        
        $expiresAt = Carbon::now()->endOfDay();
        \Cache::store('database')->put($key, $data, $expiresAt);
        return $data;
    }


    private function quandlCode()
    {
        $database_code = $this->source->first()->database->code;
        $dataset_code = $this->source->first()->dataset->code;

        $quandlCode = "{$database_code}/{$dataset_code}";
        return $quandlCode;
    }


    public function getJsonHistory($parameter = [])
    {
        $json = $this->client->getSymbol($this->quandlCode(), $parameter);

        if (!is_null($this->client->error)) {
            throw new QuandlException($this->client->error);
        }
        return $json;
    }


    public function getArrayHistory($parameter = [])
    {
        $data = json_decode($this->getJsonHistory($parameter), true);

        $timeSeries = $data['dataset']['data'];
        $columnNames = $data['dataset']['column_names'];
        
        $n = $this->priceColumn($columnNames);
        $y = [];
        foreach($timeSeries as $x)
        {
            $y[$x[0]] = $x[$n];
        }

        return $y;
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


    private function getDatasource($code)
    {
        return Datasource::withDataset($code);
    }
}