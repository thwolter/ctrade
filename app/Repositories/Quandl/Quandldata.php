<?php

namespace App\Repositories\Quandl;

use App\Entities\Database;
use App\Entities\Dataset;
use App\Models\Exceptions\QuandlException;
use App\Models\Pathway;

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
        $database_code = $this->path->database->code;
        $dataset_code = $this->path->dataset->code;

        $quandlCode = "{$database_code}/{$dataset_code}";
        $data = json_decode($this->client->getSymbol($quandlCode, ['limit' => 1]), true);

        if (! is_null($this->client->error)) {
            throw new QuandlException($this->client->error);
        }

        $column = array_search('Last', $data['dataset']['column_names']);
        return $data['dataset']['data'][0][$column];
    }
}