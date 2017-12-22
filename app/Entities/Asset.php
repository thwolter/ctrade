<?php

namespace App\Entities;

use App\Presenters\AssetPresenter;
use App\Presenters\Presentable;
use App\Repositories\CurrencyRepository;
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

    public function value($date = null)
    {
        return $this->amount($date) * array_first($this->price($date));
    }

    public function amount($date = null)
    {
        return $this->positions()
            ->where('executed_at', '<=', Carbon::parse($date)->endOfDay())
            ->sum('amount');
    }

    public function price($date = null)
    {
        return $this->positionable->price($date);
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
        return implode('.', [$this->positionable_type, $this->positionable_id]);
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

    public function toArrayWithPrice()
    {
        $price = $this->price();

        return array_merge($this->toArray(), [
            'price' => head($price),
            'total' => $this->value(),
            'date' => key($price),
            'currency' => $this->currency()
        ]);
    }


    public function isType($type)
    {
        return class_basename($this->positionable) === $type;
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
        return strtolower(class_basename($this->positionable_type));
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


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
