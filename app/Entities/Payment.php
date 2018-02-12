<?php

namespace App\Entities;

use App\Presenters\Presentable;
use Carbon\Carbon;
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
        'fee',
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

    public function exchange()
    {
        return $this->belongsTo(Exchange::class);
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

    public function scopeUntil($query, $date)
    {
        $date = Carbon::parse($date)->endOfDay();
        return $query->where($this->getTable(). '.executed_at', '<=', $date);
    }

    public function scopeOfType($query, $types)
    {
        return $query->whereIn('type', array_wrap($types));
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

    public function getCurrencyAttribute()
    {
        return $this->portfolio->currency;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */


}
