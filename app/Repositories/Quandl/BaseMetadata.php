<?php

// Load meta data from quandl Stuttgart exchange

namespace App\Repositories\Quandl;

use App\Entities\Metadata\Metadata;
use App\Entities\Metadata\Currency;
use App\Entities\Metadata\Database;
use App\Entities\Metadata\Dataset;
use App\Entities\Metadata\Isin;
use App\Entities\Metadata\Name;
use App\Entities\Metadata\Provider;
use App\Entities\Metadata\Sector;
use App\Entities\Metadata\Wkn;



class BaseMetadata
{
    
   protected $client;
    
    
    
    public function __construct() 
    {
        $this->client = new \Quandl(env('QUANDL_API_KEY'), 'json');
    }


    public function load($database)
    {
        $dataset = json_decode($this->client->getList($database, 1, 2), true);
        $this->get($dataset);
    }
    

    private function get($dataset)
    {
        
        foreach ($dataset as $item)
        {
            $metadata = new Metadata();
            //$metadata->save();
        
            $item = array_first($item);
           
            $raw_name = strtoupper($item['name']);
            $desc = strtoupper($item['description']);
 
            $reIsin = '/ISIN*\s*([A-Z0-9]+)/';
            $reCcy = '/CURRENCY:*\s*([A-Z]+)/';
            $reSector = '/SECTOR:*\s*([A-Z \-]*)/';

            $dataset = new Dataset(['code' => $item['dataset_code']]);
            //$dataset->metadata()->save($metadata);
            //$metadata->databases()->create(['code' => $item['database_code']]);
            //$metadata->names()->create(['name' => title_case(trim(explode('WKN', (explode('|', $raw_name)[0]))[0]))]);
            //$metadata->wkns()->create(['wkn' => trim(explode('WKN', (explode('|', $raw_name)[0]))[1])]);
            //$metadata->isins()->create(['isin' => (preg_match($reIsin, $raw_name, $matches)) ? $matches[1] : null]);
            //$metadata->isos()->create(['iso' => (preg_match($reCcy, $desc, $matches)) ? $matches[1] : null]);
            //$metadata->sectors()->create(['sector' => (preg_match($reSector, $desc, $matches)) ? title_case($matches[1]) : null]);

            //$firstDate = $item['oldest_available_date'];
            //$lastDate = $item['newest_available_date'];
           
        }
    }
        
    
}

