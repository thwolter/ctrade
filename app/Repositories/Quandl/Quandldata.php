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
        
        $json = $this->client->getSymbol([
            'limit' => 1,
            'database_code' => Database::find($pathway['database']),
            'dataset_code' => Dataset::find($pathway['dataset'])->get()
        ]);
    }
}