<?php


namespace App\Entities;


use App\Presenters\Presentable;
use App\Presenters\StockPresenter;
use App\Services\StockMetrics;
use Backpack\CRUD\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Support\Facades\Cache;
use Venturecraft\Revisionable\RevisionableTrait;


class Stock extends Instrument
{
    use CrudTrait, RevisionableTrait, Sluggable, SluggableScopeHelpers;

    use Presentable;


    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = ['name', 'name_overwrite', 'wkn', 'isin'];

    protected $presenter = StockPresenter::class;


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
