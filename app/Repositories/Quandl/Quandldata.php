<?php

namespace App\Repositories\Quandl;

use App\Entities\Database;
use App\Entities\Dataset;
use App\Models\Exceptions\QuandlException;
use App\Models\Pathway;
use Carbon\Carbon;

class Quandldata extends \Quandl
{

    protected $priceColumnNames = ['Last', 'Close'];

    protected $client;
    protected $path;
    
    
    public function __construct(Pathway $path)
    {
        $this->client = new \Quandl(env('QUANDL_API_KEY'), 'json');
        $this->path = $path;
    }

    
    static public function make($path)
    {
        return new Quandldata($path);
    }
    
    
    public function price()
    {
        return $this->getArrayHistory(['limmit' => 1])[0];
    }


    public function history($parameter = ['limit' => 250])
    {
        return $this->getArrayHistory($parameter);
    }


    private function quandlCode(): string
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
}