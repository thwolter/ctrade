<?php

namespace App\Repositories\Quandl;

use App\Entities\Database;
use App\Entities\Dataset;
use App\Models\Exceptions\QuandlException;
use App\Models\Pathway;
use Carbon\Carbon;

class Quandldata extends \Quandl
{
    
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
        $data = json_decode($this->getJsonHistory(['limit' => 1]), true);

        $column = array_search('Last', $data['dataset']['column_names']);
        return $data['dataset']['data'][0][$column];
    }


    public function history(Carbon $from = null, Carbon $to = null)
    {
        $data = json_decode($this->getJsonHistory(['limit' => 1]), true);

        $column = array_search('Last', $data['dataset']['column_names']);
        return $data['dataset']['data'][0][$column];
    }


    private function quandlCode(): string
    {
        $database_code = $this->path->database->code;
        $dataset_code = $this->path->dataset->code;

        $quandlCode = "{$database_code}/{$dataset_code}";
        return $quandlCode;
    }


    private function getJsonHistory($parms = [])
    {
        $json = $this->client->getSymbol($this->quandlCode(), $parms);

        if (!is_null($this->client->error)) {
            throw new QuandlException($this->client->error);
        }
        return $json;
    }
}