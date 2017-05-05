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
        $items = json_decode($this->client->getList($database, 1, 100), true);

        foreach ($items['datasets'] as $item)
        {
            $metadata = new Metadata([
                'symbol' => $this->getSymbol($item),
                'name_id' => $this->getNameId($item),
                'currency_id' => $this->getCurrencyId($item),
                'provider_id' => $this->getProviderId($item),
                'database_id' => $this->getDatabaseId($item),
                'wkn_id' => $this->getWknId($item),
                'isin_id' => $this->getIsinId($item)
            ]);

            $metadata->save();
        }
    }

    public function getSymbol($item)
    {
        return $item['dataset_code'];
    }

    public function getProviderId($item)
    {
        $entry = Provider::firstOrCreate(['name' => 'Quandl']);
        return $entry->id;
    }


    public function getDatabaseId($item)
    {
        $entry = Database::firstOrCreate(['code' => $item['database_code']]);
        return $entry->id;
    }


    public function getNameId($item)
    {
        $raw_name = strtoupper($item['name']);
        $name = trim(explode('WKN', (explode('|', $raw_name)[0]))[0]);

        $entry = Name::firstOrCreate(['name' => title_case($name)]);
        return $entry->id;
    }

    public function getWknId($item)
    {
        $raw_name = strtoupper($item['name']);
        $wkn = trim(explode('WKN', (explode('|', $raw_name)[0]))[1]);

        $entry = Wkn::firstOrCreate(['wkn' => $wkn]);
        return $entry->id;
    }

    public function getIsinId($item)
    {
        $raw_name = strtoupper($item['name']);
        $re = '/ISIN*\s*([A-Z0-9]+)/';
        $isin = preg_match($re, $raw_name, $matches) ? $matches[1] : null;

        $entry = Isin::firstOrCreate(['isin' => $isin]);
        return $entry->id;
    }

    public function getCurrencyId($item)
    {

        $desc = strtoupper($item['description']);
        $re = '/CURRENCY:*\s*([A-Z]+)/';

        $currency = preg_match($re, $desc, $matches) ? $matches[1] : null;

        $entry = Currency::firstOrCreate(['iso' => $currency]);
        return $entry->id;
    }


    public function getSectorId($item)
    {
        $desc = strtoupper($item['description']);
        $re = '/SECTOR:*\s*([A-Z \-]*)/';

        $sector = preg_match($re, $desc, $matches) ? title_case($matches[1]) : null;

        $entry = Isin::firstOrCreate(['sector' => $sector]);
        return $entry->id;
    }
}

