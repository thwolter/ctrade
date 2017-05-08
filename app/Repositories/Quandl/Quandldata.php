<?php

namespace App\Repositories\Quandl;

use App\Entities\Database;
use App\Entities\Dataset;


class Quandldata extends \Quandl
{
    
    protected $client;
    
    
    public function __construct()
    {
        $this->client = new \Quandl(env('QUANDL_API_KEY'), 'json');
    }

    
    static public function make()
    {
        return new Quandldata();
    }
    
    
    public function price($pathway)
    {
        //ToDo: read price from json

        $database_code = Database::find($pathway['database'])->code;
        $dataset_code = Dataset::find($pathway['dataset'])->code;

        $quandlCode = "{$database_code}/{$dataset_code}";
        $data = json_decode($this->client->getSymbol($quandlCode, ['limit' => 1]), true);

        $column = array_search('Last', $data['dataset']['column_names']);
        return $data['dataset']['data'][0][$column];
    }
}