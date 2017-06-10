<?php


namespace App\Entities;



use App\Presenters\Presentable;
use App\Repositories\DataRepository;
use Laravel\Scout\Searchable;

class Stock extends Instrument
{

    use Searchable;

    use Presentable;

    protected $fillable = ['name', 'wkn', 'isin'];

    protected $financial = DataRepository::class;

    protected $presenter = \App\Presenters\Stock::class;
    
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


    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'sector' => ($this->sector) ? $this->sector->name : '',
            'industry' => ($this->industry) ? $this->industry->name : '',
            'isin' => $this->isin,
            'wkn' => $this->wkn,
            'currency' => $this->currencyCode(),
        ];
    }

}
