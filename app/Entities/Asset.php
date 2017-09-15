<?php

namespace App\Entities;

use App\Presenters\Presentable;
use App\Repositories\CurrencyRepository;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use Presentable, SoftDeletes, CascadeSoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $presenter = 'App\Presenters\Asset';

    protected $fillable = ['positionable_type', 'positionable_id'];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function positionable()
    {
        return $this->morphTo();
    }


    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }


    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function obtain($position)
    {
        $this->positions()->save($position);
    }

    public function value()
    {
        return $this->amount() * array_first($this->price());
    }

    public function amount()
    {
        return $this->positions()->sum('amount');
    }

    public function price()
    {
        return $this->positionable->price();
    }

    public function currency()
    {
        return $this->positionable->currency;
    }


    public function convert($currencyCode = null)
    {
        if (!$currencyCode or $this->currency->code === $currencyCode) return 1;

        return array_first((new CurrencyRepository($this->currency->code, $currencyCode))->price());
    }

    public function label()
    {
        return class_basename($this->positionable_type).$this->positionable_id;
    }

    public function toArray()
    {
        return [
            'name' => $this->positionable->name,
            'type' => $this->positionable_type,
            'symbol' => $this->label(),
            'currency' => $this->currency->code,
            'amount' => $this->amount(),
        ];
    }

    public function isType($type)
    {
        return class_basename($this->positionable) === $type;
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeOfType($query, $entity)
    {
        return $query->where('positionable_type', $entity);
    }


    public function scopeWithId($query, $id)
    {
        return $query->where('positionable_id', $id);
    }


    public function scopeWhereSlug($query, $slug)
    {
        $asset = $query->with('positionable')->get()->filter(function ($item) use ($slug){
            return array_get($item, 'positionable.slug') === $slug;
        })->first();

        return $query->whereId($asset->id);
    }



    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    public function getSlugAttribute()
    {
        return $this->positionable->slug;
    }

    public function getCurrencyAttribute()
    {
        return $this->positionable->currency;
    }


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
