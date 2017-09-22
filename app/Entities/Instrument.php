<?php


namespace App\Entities;


use App\Exceptions\InstrumentException;
use App\Repositories\Contracts\InstrumentInterface;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use App\Repositories\Financable;

use App\Models\QuantModel;


abstract class Instrument extends Model
{
    
    use Financable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function positions()
    {
        return $this->morphMany(Position::class, 'positionable');
    }


    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }


    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }


    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }


    public function datasources()
    {
        return $this->morphToMany(Datasource::class, 'sourcable')->withTimestamps();
    }



    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Return the class_basename of the instrument.
     *
     * @param bool $toLower
     * @return string
     */
    public function type($toLower = false)
    {
        $name = class_basename($this);
        return $toLower ? strtolower($name) : $name;
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function exchangesAsAssociativeArray()
    {
        $array = [];
        foreach ($this->datasources as $datasource)
        {
            $array[$datasource->exchange->code] = $datasource->exchange->name;
        }
        return $array;
    }


    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */


    public function getIndustryNameAttribute()
    {
        return $this->industry()->first()->name;
    }

    public function getSectorNameAttribute()
    {
        return $this->sector()->first()->name;
    }

    public function getCurrencyCodeAttribute()
    {
        return $this->currency()->first()->code;
    }


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}