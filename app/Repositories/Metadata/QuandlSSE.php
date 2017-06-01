<?php

namespace App\Repositories\Metadata;

use App\Entities\Sector;
use App\Entities\Stock;
use App\Entities\Currency;
use App\Repositories\Exceptions\MetadataException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class QuandlSSE extends QuandlMetadata
{
    protected $database = 'SSE';
    
    protected $required = ['symbol', 'name', 'currency'];

    protected $useFile = true;


    static public function sync()
    {
        $meta = new self();
        $meta->load();
    }

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

        $stock->save();

        return $stock;
    }
    
    
    public function updateItem($item)
    {
        //Todo: check for security type, for now assume all are stocks
        //Todo: check whether stock should be updated based on wkn, isin, name

        return false;

        //return true if updated
    }


    public function symbol($item)
    {
        return $item['dataset_code'];
    }

    public function name($item)
    {
        $raw_name = strtoupper($item['name']);
        $name = trim(explode('WKN', (explode('|', $raw_name)[0]))[0]);

        return (empty($name)) ? null : title_case($name);
    }

    public function wkn($item)
    {
        $raw_name = strtoupper($item['name']);

        //Todo: check errors
        $wkn = @trim(explode('WKN', (explode('|', $raw_name)[0]))[1]);

        return (empty($wkn)) ? null : $wkn;

    }

    public function isin($item)
    {
        $raw_name = strtoupper($item['name']);
        $re = '/ISIN*\s*([A-Z0-9]+)/';
        return preg_match($re, $raw_name, $matches) ? $matches[1] : null;
    }

    public function currency($item)
    {
        $desc = strtoupper($item['description']);
        $re = '/CURRENCY:*\s*([A-Z]+)/';

        return preg_match($re, $desc, $matches) ? $matches[1] : null;
    }

    public function sector($item)
    {
        $desc = strtoupper($item['description']);
        $re = '/SECTOR:*\s*([A-Z \-]*)/';

        return preg_match($re, $desc, $matches) ? title_case($matches[1]) : null;
    }

    public function model($item)
    {
        return Stock::class;
    }

    public function getItemsFromFile()
    {
        return json_decode(Storage::get('QuandlSSE.json'), true)['datasets'];
    }



}

