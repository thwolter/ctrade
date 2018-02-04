<?php

namespace App\Entities;

use App\Entities\Traits\CacheDatasource;
use Illuminate\Database\Eloquent\Model;

class CcyPair extends Model
{
    use CacheDatasource;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = ['origin', 'target'];


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    public function datasources()
    {
        return $this->morphToMany(Datasource::class, 'sourcable')->withTimestamps();
    }


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */


    public function symbol()
    {
        return $this->origin.$this->target;
    }


    public function datasource()
    {
        return $this->datasources->first();
    }


    public function exchangesToArray()
    {
        $array = [];
        foreach ($this->cached_datasources as $datasource)
        {
            $array[] = [
                'code' => $datasource->exchange->code,
                'name' => $datasource->exchange->name
            ];
        }
        return $array;
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeWhereSymbol($query, $symbol)
    {
        return $query
            ->whereOrigin(substr($symbol, 0, 3))
            ->whereTarget(substr($symbol, strlen($symbol)-3), strlen($symbol));
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    public function getCurrencyAttribute()
    {
        return Currency::whereCode($this->target)->first();
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */


}
