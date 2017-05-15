<?php


namespace App\Entities;



use App\Repositories\DataRepository;

class Stock extends Instrument
{
    protected $fillable = ['name', 'wkn', 'isin'];

    protected $financial = DataRepository::class;
    
    public $typeDisp = 'Aktie';


    static public function saveWithParameter($parameter)
    {
        $stock = Stock::firstOrNew(['name' => $parameter['name']]);

        Currency::firstOrCreate(['code' => $parameter['currency']])
            ->stocks()->save($stock);

        if (!is_null($parameter['sector']))
            Sector::firstOrCreate(['name' => $parameter['sector']])->stocks()->save($stock);

        if (array_has($parameter, 'wkn')) $stock->wkn = $parameter['wkn'];
        if (array_has($parameter, 'isin')) $stock->isin = $parameter['isin'];

        $stock->save();

        return $stock;
    }

}
