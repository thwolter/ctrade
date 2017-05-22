<?php

namespace App\Repositories\Quandl;

use App\Entities\Database;
use App\Entities\Dataset;
use App\Models\Exceptions\QuandlException;
use App\Models\Pathway;
use Carbon\Carbon;

class Quandldata
{

    protected $priceColumnNames = ['Last', 'Close'];

    protected $client;
    protected $path;


    /**
     * Quandldata constructor.
     * @param string $code of a dataset
     */
    public function __construct(String $code)
    {
        $this->client = new \Quandl(env('QUANDL_API_KEY'), 'json');
        $this->path = $this->getPathway($code);
    }


    public function price()
    {
        return $this->getArrayHistory(['limit' => 1])[0];
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
        $quandl = new Quandldata($code);
        return $quandl->history($parameter);
    }


    private function quandlCode()
    {
        $database_code = $this->path->first()->database->code;
        $dataset_code = $this->path->first()->dataset->code;

        $quandlCode = "{$database_code}/{$dataset_code}";
        return $quandlCode;
    }


    private function getJsonHistory($parameter = [])
    {
        $json = $this->client->getSymbol($this->quandlCode(), $parameter);

        if (!is_null($this->client->error)) {
            throw new QuandlException($this->client->error);
        }
        return $json;
    }


    private function getArrayHistory($parameter = [])
    {
        $data = json_decode($this->getJsonHistory($parameter), true);

        $timeSeries = $data['dataset']['data'];
        $columnNames = $data['dataset']['column_names'];

        return array_column($timeSeries, $this->priceColumn($columnNames));


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


    private function getPathway($code)
    {
        return Pathway::withDatasetCode($code)->first();
    }
}