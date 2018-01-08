<?php

namespace App\Entities;

use App\Repositories\Financable;
use Illuminate\Database\Eloquent\Model;

class CcyPair extends Model
{

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


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */


}
