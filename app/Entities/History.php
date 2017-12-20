<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class History extends Model
{

    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'values',
        'effective_at'
    ];

    protected $casts = [
        'values' => 'json'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'effective_at'
    ];


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function historable()
    {
        return $this->morphTo();
    }



    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */


    public function get($key)
    {
        return array_get($this->values, $key);
    }

    public function set($key, $value)
    {
        $values = $this->values;
        $values[$key] = $value;

        $this->update(['values' => $values]);
    }

    public function has($key)
    {
        return array_key_exists($key, $this->values);
    }

    private function hasValues()
    {
        return count($this->values) > 0;
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->values = [];
        });
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeOfType($query, $type)
    {
        return $query->whereHas('type', function ($query) use ($type) {
            $query->whereCode($type);
        });
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
