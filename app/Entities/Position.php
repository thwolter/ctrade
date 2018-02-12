<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Position extends Model
{
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */


    protected $fillable = [
        'executed_at',
        'amount',
        'price',
        'fxrate'
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


    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }


    public function payments()
    {
        return $this->hasMany(Payment::class);
    }



    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function obtain(Payment $payment, $exchange = '')
    {
        $this->asset->portfolio->payments()->save($payment);
        $payment->position()->associate($this)->save();

        if ($exchange) {
            $payment->exchange()
                ->associate(Exchange::firstOrCreate(['code' => $exchange])->first())
                ->save();
        }

        return $payment;
    }

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
        return $query->where($this->getTable().'.executed_at', '<=', $date);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    public function getExchangeAttribute()
    {
        return $this->payments()->has('exchange')->first()->exchange->code;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

}

