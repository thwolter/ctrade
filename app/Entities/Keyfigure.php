<?php

namespace App\Entities;

use App\Classes\TimeSeries;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keyfigure extends Model
{

    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'values',
        'term_id',
        'calculated_at',
        'instrument_type',
        'instrument_id'
    ];

    protected $casts = [
        'values' => 'json'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'calculated_at'
    ];


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public static function boot()
    {
        parent::boot();
        static::creating(function ($keyfigures) {
            $keyfigures->values = [];
        });
    }

    public function keyfigureable()
    {
        return $this->morphTo();
    }


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function get($key)
    {
        return array_get($this->values, $key);
    }


    public function set($key, $value)
    {
        $values = $this->values;
        $values[$key] = $value;

        $this->update(['values' => $values]);
        return $this;
    }


    public function setCalculatedAt($date)
    {
        $this->calculated_at = $date;
        return $this;
    }

    public function timeseries()
    {
        return new TimeSeries($this->values);
    }


    public function has($key)
    {
        return array_key_exists($key, $this->values);
    }


    public function obtain($instrument)
    {
        $this->update([
            'instrument_id' => $instrument->id,
            'instrument_type' => get_class($instrument)
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeOfType($query, $type)
    {
        return $query->whereHas('term', function ($query) use ($type) {
            $query->whereCode($type);
        });
    }


    public function scopeWhereInstrument($query, $instrument)
    {
        return $query
            ->where('instrument_type', get_class($instrument))
            ->where('instrument_id', $instrument->id);
    }


    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    public function getValueAttribute()
    {
        return $this->values ? array_last($this->values) : [];
    }

    public function getDateAttribute()
    {
        return $this->values ? Carbon::parse(array_last(array_keys($this->values))) : null;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

}
