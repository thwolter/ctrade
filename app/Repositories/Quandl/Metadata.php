<?php

// Load meta data from quandl Stuttgart exchange

namespace App\Repositories\Quandl;


//require_once base_path()."/vendor/dannyben/php-quandl/Quandl.php";

class Metadata
{
    
   protected $client;
    
    
    
    public function __construct() 
    {
        $this->client = new Quandl(env('QUANDL_API_KEY'), 'json');
    }


    public function getList($database)
    {
        $dataset = json_decode($quandl->getList($database, 1, 10), true);
        $this->store($this->get($dataset));
    }
    

    private function get($dataset)
    {
        foreach ($dataset as $item)
        {
            $raw_name = strtoupper($item['dataset']['name']);
            $desc = strtoupper($item['dataset']['description']);

            $reIsin = '/ISIN*\s*([A-Z0-9]+)/';
            $reCcy = '/CURRENCY:*\s*([A-Z]+)/';
            $reSector = '/SECTOR:*\s*([A-Z \-]*)/';

            $entry = [
                'dataset_code' => $item['dataset']['dataset_code'],
                'database_code' => $item['dataset']['database_code'],
                'firstDate' => $item['dataset']['oldest_available_date'],
                'lastDate' => $item['dataset']['newest_available_date'],
                'name' => trim(explode('WKN', (explode('|', $raw_name)[0]))[0]),
                'wkn' => trim(explode('WKN', (explode('|', $raw_name)[0]))[1]),
                'isin' => (preg_match($reIsin, $raw_name, $matches)) ? $matches[1] : null,
                'currency' => (preg_match($reCcy, $desc, $matches)) ? $matches[1] : null,
                'sector' => (preg_match($reSector, $desc, $matches)) ? $matches[1] : null
            ];

            return $entry;
        }
    }
        

    public function store($entry)
    {
        dd($entry);
    }
    
}

