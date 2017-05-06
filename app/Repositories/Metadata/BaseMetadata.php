<?php


namespace App\Repositories\Metadata;

use App\Entities\Metadata\Metadata;
use App\Entities\Metadata\Currency;
use App\Entities\Metadata\Database;
use App\Entities\Metadata\Provider;
use App\Entities\Stock;
use App\Repositories\Exceptions\MetadataException;



class BaseMetadata
{
    
    protected $require = ['Symbol', 'Name', 'Currency'];

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
            if ($this->isValid($item)) {
                $metadata = new Metadata([
                    'symbol' => $this->getSymbol($item),
                    'provider_id' => $this->getProviderId($item),
                    'database_id' => $this->getDatabaseId($item),
                    'instrumentable_id'
                ]);

                $metadata->save();
            }
        }
    }

    public function isValid($item)
    {
        foreach ($this->require as $field)
        {
            $method = 'get'.studly_case($field);
            if (!method_exists($this, $method)) $method = $method . 'Id';

            if (!method_exists($this, $method))
                throw new MetadataException("no method '{$method}' defined");

            $id = $this->$method($item);

            return (is_null($id) ? false : true);
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


    public function getInstrumentable($item)
    {
        // Todo: define Instrumentable
        // find Stock be Wkn or Isin
        // create if not exists
        // return array with id and type
    }

    public function getName($item)
    {
        $raw_name = strtoupper($item['name']);
        return trim(explode('WKN', (explode('|', $raw_name)[0]))[0]);
    }

    public function getWkn($item)
    {
        $raw_name = strtoupper($item['name']);
        return trim(explode('WKN', (explode('|', $raw_name)[0]))[1]);
    }

    public function getIsin($item)
    {
        $raw_name = strtoupper($item['name']);
        $re = '/ISIN*\s*([A-Z0-9]+)/';
       return preg_match($re, $raw_name, $matches) ? $matches[1] : null;
    }

    public function getCurrency($item)
    {
        $desc = strtoupper($item['description']);
        $re = '/CURRENCY:*\s*([A-Z]+)/';

        return preg_match($re, $desc, $matches) ? $matches[1] : null;
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

