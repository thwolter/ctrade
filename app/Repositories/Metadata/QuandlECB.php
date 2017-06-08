<?php


namespace App\Repositories\Metadata;


use App\Entities\CcyPair;
use App\Entities\Currency;
use App\Entities\Datasource;
use App\Repositories\Exceptions\MetadataException;


class QuandlECB extends QuandlMetadata
{

    protected $database = 'ECB';
    protected $origin = 'EUR';
    protected $baseCcy = ['USD', 'CHF'];


   
    public function saveItem($item)
    {
        $currency = CcyPair::firstOrCreate([
            'origin' => $this->origin,
            'target' => $item,
        ]);

        return $currency;
    }
    
    
    public function updateItem($item)
    {
        //Todo: check for security type, for now assume all are stocks
        //Todo: check whether stock should be updated based on wkn, isin, name

        return false;

        //return true if updated
    }

}