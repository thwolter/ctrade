<?php


namespace App\Entities;



class Stock extends Instrument
{
    protected $fillable = ['name', 'wkn', 'isin'];

    protected $financial = 'App\Repositories\Yahoo\StockFinancial';
    
    public $typeDisp = 'Aktie';


    static public function saveWithParameter($parameter)
    {
        $stock = Stock::firstOrNew(['name' => $parameter['name']]);

        Currency::firstOrCreate(['code' => $parameter['currency']])
            ->stocks()->save($stock);

        is_null($parameter['sector']) or Sector::firstOrCreate(['name' => $parameter['sector']])
            ->stocks()->save($stock);

        is_null($parameter['wkn']) or $stock->wkn = $parameter['wkn'];
        is_null($parameter['isin']) or $stock->isin = $parameter['isin'];

        $stock->save();

        return $stock;
    }

}
