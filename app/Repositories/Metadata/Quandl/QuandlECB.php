<?php


namespace App\Repositories\Metadata\Quandl;


use App\Entities\CcyPair;


class QuandlECB extends QuandlMetadata
{

    public $database = 'ECB';
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
    
    
    public function update($item)
    {
        //Todo: check for security type, for now assume all are stocks
        //Todo: check whether stock should be updated based on wkn, isin, name

        return false;

        //return true if updated
    }

}