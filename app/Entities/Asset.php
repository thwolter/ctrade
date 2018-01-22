<?php

namespace App\Entities;

use App\Presenters\AssetPresenter;
use App\Presenters\Presentable;
use Carbon\Carbon;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    use Presentable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $presenter = AssetPresenter::class;

    protected $fillable = [
        'positionable_type',
        'positionable_id'
    ];

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
        return $this;
    }


    public function toArray($date = null)
    {
        return [
            'name' => $this->positionable->name,
            'type' => $this->positionable_type,
            'symbol' => $this->label(),
            'currency' => $this->currency->code,
            'amount' => $this->amount($date),
        ];
    }


    public function isType($type)
    {
        return ucfirst(class_basename($this->positionable)) === ucfirst($type);
    }


    public function amountAt($date)
    {
        return $this->positions()
            ->where('executed_at', '<=', Carbon::parse($date)->endOfDay())
            ->sum('amount');
    }


    public function hasForeignCurrency()
    {
        return $this->currency->code != $this->portfolio->currency->code;
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

    public function getTypeAttribute()
    {
        return ucfirst(class_basename($this->positionable_type));
    }

    public function getSlugAttribute()
    {
        return $this->positionable->slug;
    }

    public function getCurrencyAttribute()
    {
        return $this->positionable->currency;
    }

    public function getNameAttribute()
    {
        return $this->positionable->name;
    }

    public function getAmountAttribute()
    {
        return $this->positions()->sum('amount');
    }

    public function getLabelAttribute()
    {
        return implode('.', [$this->positionable->type(), $this->positionable->id]);
    }

    public function getExchangeAttribute()
    {
        return $this->positions->last()->exchange;
    }


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
