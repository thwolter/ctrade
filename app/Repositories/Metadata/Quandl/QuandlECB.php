<?php


namespace App\Repositories\Metadata\Quandl;


use App\Entities\CcyPair;
use App\Repositories\Contracts\MetadataInterface;


class QuandlECB extends QuandlMetadata implements MetadataInterface
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

    /**
     * Persist the item to the database. To decide which tables are effected and trait could be
     * use for various asset classes. The function should return true when successfully persisted.
     *
     * @param $item
     * @return mixed
     */
    function create($item)
    {
        // TODO: Implement create() method.
    }
}