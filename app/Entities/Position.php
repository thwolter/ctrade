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
    use Financable, Presentable, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $presenter = \App\Presenters\Position::class;

    protected $fillable = [
        'positionable_type',
        'positionable_id',
        'amount'
    ];

    protected $dates = ['deleted_at'];


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


    public function datasource()
    {
        return $this->belongsTo(Datasource::class)->withDefault();
    }


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function price()
    {
        return $this->positionable->price();
    }

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

    public function typeDisp()
    {
        return $this->positionable->typeDisp;
    }

    public function amount()
    {
        return $this->amount;
    }

    public function name()
    {
        return $this->positionable->name;
    }


    public function symbol()
    {
        return $this->positionable->symbol;
    }

    public function total($currency = null)
    {
        return $this->amount() * array_first($this->price()) * $this->convert($currency);
    }


    public function convert($currencyCode = null)
    {

        if (is_null($currencyCode) or $this->currencyCode() == $currencyCode) return 1;

        return array_first((new CurrencyRepository($this->currencyCode(), $currencyCode))->price());
    }


    public function hasCurrency($currency)
    {
        return $this->currency() == $currency;
    }


    public function toArray()
    {

        $type = $this->positionable_type;

        return [
            'name' => $this->name(),
            'type' => $type,
            'symbol' => "{$type}_{$this->positionable_id}",
            'currency' => $this->currencyCode(),
            'amount' => $this->amount,
        ];
    }

    public function history($dates)
    {
        return $this->positionable->history($dates);
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

