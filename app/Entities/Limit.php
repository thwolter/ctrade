<?php

namespace App\Entities;

use App\Classes\Limits\AbstractLimit;
use App\Presenters\LimitPresenter;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Limit extends Model
{
    use Presentable, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $presenter = LimitPresenter::class;

    protected $fillable = [
        'type',
        'value',
        'date',
        'notify'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }



    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function toArray()
    {
        return $this->getAttributes();
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeFinite($query)
    {
        return $query->where('date', '!=', null);
    }

    public function scopeInfinite($query)
    {
        return $query->where('date', null);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
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
