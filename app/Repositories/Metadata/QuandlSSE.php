<?php

namespace App\Repositories\Metadata;

use App\Entities\Industry;
use App\Entities\Sector;
use App\Entities\Stock;
use App\Entities\Currency;
use App\Repositories\Exceptions\MetadataException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class QuandlSSE extends QuandlMetadata
{
    public $database = 'SSE';
    
    protected $required = ['symbol', 'name', 'currency'];

    protected $useFile = true;


    

    public function isValid($item)
    {
        foreach ($this->required as $method)
        {
            if (!method_exists($this, $method))
                throw new MetadataException("no method '{$method}' defined");

            $result = $this->$method($item);
            if (is_null($result) or empty($result)) {
                
                Log::notice('symbol '.$this->symbol($item).' marked as invalid');
                return false;
            }
        }
        return true;
    }


    public function saveItem($item)
    {
        //Todo: check for security type, for now assume all are stocks

        if (!$this->isValid($item)) return null;

        $currency = Currency::whereCode($this->currency($item))->first();
        
        if (is_null($currency)) {
            Log::notice("item with dataset {$this->symbol($item)} not stored (requires currency {$this->currency($item)})");
            return null;
        }

        $stock = Stock::firstOrNew([
            'name' => $this->name($item),
            'wkn'  => $this->wkn($item),
            'isin' => $this->isin($item)
        ]);

        $currency->stocks()->save($stock);

        if (! is_null($this->sector($item)))
            Sector::firstOrCreate(['name' => $this->sector($item)])->stocks()->save($stock);

        if (! is_null($this->industry($item)))
            Industry::firstOrCreate(['name' => $this->industry($item)])->stocks()->save($stock);

        $stock->save();

        return $stock;
    }
    
    
    public function updateItem($item)
    {
        parent::updateItem($item);

        //Todo: check for security type, for now assume all are stocks
        //Todo: check whether stock should be updated based on wkn, isin, name

        return false;

        //return true if updated
    }


    public function symbol($item)
    {
        return $item['dataset_code'];
    }


    public function description($item)
    {
        return $item['description'];
    }


    public function name($item)
    {
        $raw_name = strtoupper($item['name']);
        $name = trim(explode('WKN', (explode('|', $raw_name)[0]))[0]);

        if (!empty($name))
            return title_case($name);
        else 
            $this->unableLog('name', $item);
    }

    
    public function wkn($item)
    {
        $raw_name = strtoupper($item['name']);

        //Todo: check errors
        $wkn = @trim(explode('WKN', (explode('|', $raw_name)[0]))[1]);

        if (!empty($wkn))
            return $wkn;
        else
            return $this->unableLog('WKN', $item);
    }

    public function isin($item)
    {
        $raw_name = strtoupper($item['name']);
        $re = '/ISIN*\s*([A-Z0-9]+)/';
        $match = preg_match($re, $raw_name, $matches);
        
        if ($match) 
            return $matches[1];
        else 
            return $this->unableLog('ISIN', $item);
    }

    public function currency($item)
    {
        $desc = strtoupper($item['description']);
        $re = '/CURRENCY:*\s*([A-Z]+)/';

        $match = preg_match($re, $desc, $matches);
        
        if ($match)
            return $matches[1];
        else
            return $this->unableLog('currency', $item);
    }


    public function sectorAndIndustry($item)
    {
        $desc = strtoupper($item['description']);
        $re = '/SECTOR:*\s*([A-Z \/ \& \-\(\)]*)/';

        return (preg_match($re, $desc, $matches)) ? $matches[1] : null;
    }


    public function sector($item)
    {
        $sector = title_case(trim(explode('-', $this->sectorAndIndustry($item))[0]));
        
        if (!empty($sector))
            return $sector;
        else 
            return $this->unableLog('sector', $item);
    }


    public function industry($item)
    {
        $split = explode(' - ', $this->sectorAndIndustry($item));
        
        if (count($split) == 2) 
            return title_case(trim($split[1]));
        else
            return $this->unableLog('industy', $item);
    }


    public function model($item)
    {
        return Stock::class;
    }


    public function getItemsFromFile()
    {
        return json_decode(Storage::get('QuandlSSE.json'), true)['datasets'];
    }



    private function unableLog($param, $item)
    {
        Log::notice("could not find {$param} for {$this->symbol($item)} -- {$this->description($item)}");
        
        return null;
    }

}

