<?php


namespace App\Entities;


use App\Presenters\Presentable;
use App\Repositories\DataRepository;
use Laravel\Scout\Searchable;

/**
 * App\Entities\Stock
 *
 * @property int $id
 * @property string $name
 * @property int $currency_id
 * @property string $wkn
 * @property string $isin
 * @property int $sector_id
 * @property int $industry_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Entities\Currency $currency
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Datasource[] $datasources
 * @property-read \App\Entities\Industry $industry
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Position[] $positions
 * @property-read \App\Entities\Sector $sector
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Stock whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Stock whereCurrencyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Stock whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Stock whereIndustryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Stock whereIsin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Stock whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Stock whereSectorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Stock whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Stock whereWkn($value)
 * @mixin \Eloquent
 */
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

        if (!is_null(array_get($parameter, 'sector')))
            Sector::firstOrCreate(['name' => $parameter['sector']])->stocks()->save($stock);

        if (!is_null(array_get($parameter, 'industry')))
            Industry::firstOrCreate(['name' => $parameter['industry']])->stocks()->save($stock);


        $stock->save();
        return $stock;
    }


    public function toSearchableArray()
    {
        return $this->toReadableArray();
    }

    public function toReadableArray()
    {
        return array_merge(
            array_except($this->toArray(), ['currency_id', 'sector_id', 'industry_id']),
            [
                'sector' => ($this->sector) ? $this->sector->name : '',
                'industry' => ($this->industry) ? $this->industry->name : '',
                'currency' => $this->currencyCode(),
            ]);
    }
}
