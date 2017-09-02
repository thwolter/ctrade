<?php

namespace App\Entities;

use App\Entities\Traits\hasAliases;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Exchange extends Model
{
    use hasAliases, CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = ['code', 'name', 'name_de'];


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    public function datasources()
    {
        return $this->hasMany(Datasource::class);
    }

    public function mappings()
    {
        return $this->morphMany(Alias::class, 'mappable');
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    public function getNameAttribute($value)
    {
        return (App::getLocale('de') && $this->name_de) ? $this->name_de : $value;
    }


    public function getOriginalNameAttribute($value)
    {
        return $this->fresh()->getOriginal('name');
    }


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

}
