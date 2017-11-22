<?php

namespace App\Entities;

use App\Presenters\Presentable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    use Presentable;

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

    public function scopeLastExecution($query)
    {
        return $query->orderBy('executed_at', 'desc')->first();
    }

    public function scopeCreatedOrUpdatedAfter($query, $date)
    {
        return $query->where('updated_at', '>=', Carbon::parse($date));
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
