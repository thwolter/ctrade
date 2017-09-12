<?php

namespace App\Entities;

use App\Presenters\Contracts\PresentableInterface;
use App\Presenters\Presentable;
use App\Repositories\CurrencyRepository;
use App\Repositories\Financable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Entities\Position
 *
 * @property int $id
 * @property int $portfolio_id
 * @property int $positionable_id
 * @property string $positionable_type
 * @property float $amount
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Entities\Portfolio $portfolio
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $positionable
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Position whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Position whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Position whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Position wherePortfolioId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Position wherePositionableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Position wherePositionableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Position whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Position extends Model implements PresentableInterface
{
    use Presentable, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $presenter = 'App\Presenters\Position';

    protected $fillable = [
        'positionable_type',
        'positionable_id',
        'executed_at',
        'amount'
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

    public function positionable()
    {
        return $this->morphTo();
    }


    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */


    public function currency()
    {
        return $this->positionable->currency;
    }

    public function currencyCode()
    {
        return $this->currency()->code;
    }

    public function type()
    {
        return get_class($this->positionable);
    }


    public function sumAmount()
    {
        return $this->allRelated($this->positionable_type, $this->positionable_id)
            ->sum('amount');
    }


    public function price()
    {
        return $this->positionable->price();
    }


    public function value($currency = null)
    {
        return $this->amount * array_first($this->price()) * $this->convert($currency);
    }


    public function sumValue($currency = null)
    {
        return $this->sumAmount() * array_first($this->price()) * $this->convert($currency);
    }


    public function convert($currencyCode = null)
    {

        if (!$currencyCode or $this->currencyCode() === $currencyCode) return 1;

        return array_first((new CurrencyRepository($this->currencyCode(), $currencyCode))->price());
    }


    public function hasCurrency($currency)
    {
        return $this->currency() == $currency;
    }


    public function toArray()
    {
        return [
            'name' => $this->positionable->name,
            'type' => $this->positionable_type,
            'symbol' => "{$this->positionable_type}_{$this->positionable_id}",
            'currency' => $this->currencyCode(),
            'amount' => $this->sumAmount(),
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeWithInstrument($query, $instrument)
    {
        $type = array_search(get_class($instrument), Relation::morphMap());
        return $query->where('positionable_id', $instrument->id)->where('positionable_type', $type);
    }


    public function scopeOfType($query, $entity)
    {
        return $query->where('positionable_type', $entity);
    }

    public function scopeWithId($query, $id)
    {
        return $query->where('positionable_id', $id);
    }

    public function scopeAllRelated($query, $type, $id)
    {
        return $query->ofType($type)->withId($id);
    }

    public function scopeProxies($query)
    {
        return $query->get()->unique(function($item) {
            return $item['positionable_type'].$item['positionable_id'];
        });
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

