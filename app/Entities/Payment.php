<?php

namespace App\Entities;

use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{

    use Presentable;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $presenter = \App\Presenters\Payment::class;

    protected $fillable = [
        'amount',
        'type',
        'fees',
        'executed_at'
    ];

    protected $dates = [
        'executed_at',
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

    public function position()
    {
        return $this->belongsTo(Position::class);
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

    public function scopeUpdatedAfter($query, $date)
    {
        return $query->where($this->getTable().'.updated_at', '>=', $date);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    public function getAssetAttribute()
    {
        return optional($this->position)->asset;
    }


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */


}
