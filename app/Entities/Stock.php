<?php


namespace App\Entities;


use App\Presenters\Presentable;
use Backpack\CRUD\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Venturecraft\Revisionable\RevisionableTrait;

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
    use Presentable, CrudTrait, RevisionableTrait, Sluggable, SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = ['name', 'name_overwrite', 'wkn', 'isin'];

    protected $presenter = \App\Presenters\Stock::class;


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */


    protected function datasource()
    {
        return $this->datasources->first();
    }


    public function toSearchableArray()
    {
        return array_only($this->toArray(), [
            'id', 'isin', 'wkn', 'name', 'sector', 'industry', 'currency'
        ]);
    }


    public function toArray()
    {
        return array_merge(
            array_except(parent::toArray(), ['currency_id', 'sector_id', 'industry_id', 'datasources']),
            [
                'sector' => ($this->sector) ? $this->sector->name : '',
                'industry' => ($this->industry) ? $this->industry->name : '',
                'currency' => $this->currency->code,
            ]);
    }

    public function sluggable()
    {
        return ['slug' => ['source' => 'nameWithType']];
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeOverwritten($query)
    {
        return $query->where('name_overwrite', '!=', null);
    }


    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    public function getNameAttribute($value)
    {
        return ($this->name_overwrite) ? $this->name_overwrite : $value;
    }

    public function getOriginalNameAttribute($value)
    {
        return $this->fresh()->getOriginal('name');
    }

    public function getNameWithTypeAttribute($value)
    {
        return $this->name . ' Stock';
    }


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */


}
