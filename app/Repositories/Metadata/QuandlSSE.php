<?php

namespace App\Repositories\Metadata;

use App\Entities\Stock;
use App\Models\Pathway;
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
                
                Log::notice('symbol '.symbol($item).' marked as invalid');
                return false;
            }
        }
        return true;
    }


    public function saveItem($item)
    {
        //Todo: check for security type, for now assume all are stocks
        //Todo: check whether stock should be updated based on wkn, isin, name
        
        if (!$this->isValid($item)) return null;

        $stock = Stock::saveWithParameter([
            'name' => $this->name($item),
            'currency' => $this->currency($item),
            'sector' => $this->sector($item),
            'isin' => $this->isin($item),
            'wkn' => $this->wkn($item)
        ]);
        
        return $stock;
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
        $wkn = trim(explode('WKN', (explode('|', $raw_name)[0]))[1]);

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

