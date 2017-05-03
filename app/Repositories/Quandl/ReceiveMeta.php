<?php

// Load meta data from quandl Stuttgart exchange

namespace App\Repositories\Quandl;


require_once base_path()."/vendor/dannyben/php-quandl/Quandl.php";

class metadata
{
    
   protected $client;
    
    
    
    public function __construct() 
    {
        $this->client = new Quandl(env('QUANDL_API_KEY'), 'json');
    }


    public function getMetadata($database)
    {
        $dataset = json_decode($quandl->getList($database, 1, 10), true);
        $this->storeMetadata($dataset);
    }
    

    private function storeMetadata($dataset)
    {
        
        foreach ($dataset as $set)
        {
            $dataset_code = $item['dataset']['dataset_code'];
            $database_code = $item['dataset']['database_code'];
            $firstDate = $item['dataset']['oldest_available_date'];
            $lastDate = $item['dataset']['newest_available_date'];
            
            $raw_name = strtoupper($item['dataset']['name']);
            $desc = strtoupper($item['dataset']['description']);
            
            $name = trim(explode('WKN', (explode('|', $raw_name)[0]))[0]);
            $wkn = trim(explode('WKN', (explode('|', $raw_name)[0]))[1]);
            
            $re = '/ISIN*\s*([A-Z0-9]+)/';
            $isin = (preg_match($re, $raw, $matches)) ? $matches[1] : null;
            
            
            $re = '/CURRENCY:*\s*([A-Z]+)/';
            $currency = (preg_match($re, $desc, $matches)) ? $matches[1] : null;
            
            $re = '/SECTOR:*\s*([A-Z \-]*)/';
            $sector = (preg_match($re, $desc, $matches)) ? $matches[1] : null;
            
            
        }
    }
        
        



// fill db with above information    
    
}

