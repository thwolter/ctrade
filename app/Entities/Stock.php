<?php


namespace App\Entities;



use App\Presenters\Presentable;
use App\Repositories\DataRepository;
use Laravel\Scout\Searchable;

class Stock extends Instrument
{

    use Searchable, Presentable;

    protected $fillable = ['name', 'wkn', 'isin'];

    protected $financial = DataRepository::class;
    protected $presenter = \App\Presenters\Stock::class;
    
    public $typeDisp = 'Aktie';
    
    public $asYouType = true;
    


    static public function saveWithParameter($parameter)
    {
        $stock = Stock::firstOrNew(array_only($parameter, ['name', 'wkn', 'isin']));

        Currency::firstOrCreate(['code' => $parameter['currency']])
            ->stocks()->save($stock);

        if (! is_null(array_get($parameter, 'sector')))
            Sector::firstOrCreate(['name' => $parameter['sector']])->stocks()->save($stock);

        if (! is_null(array_get($parameter,'industry')))
            Industry::firstOrCreate(['name' => $parameter['industry']])->stocks()->save($stock);


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
            'id' => $this->id
        ];
    }
}
