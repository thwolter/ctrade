<?php


namespace App\Entities;



class Stock extends Instrument
{
    protected $fillable = ['name', 'wkn', 'isin'];

    protected $financial = 'App\Repositories\Yahoo\StockFinancial';
    
    public $typeDisp = 'Aktie';


    static public function saveWithParameter($name, $currency, $sector)
    {
        $stock = Stock::firstOrNew(['name' => $name]);

        Currency::firstOrCreate(['code' => $currency])
            ->stocks()->save($stock);

        is_null($sector) or Sector::firstOrCreate(['name' => $sector])
            ->stocks()->save($stock);

        $stock->save();

        return $stock;
    }

}
