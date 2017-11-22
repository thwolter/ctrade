<?php

namespace App\Entities;

use App\Presenters\Contracts\PresentableInterface;
use App\Presenters\Presentable;
use App\Repositories\CurrencyRepository;
use App\Repositories\Financable;
use Carbon\Carbon;
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
        return $query->where('positions.updated_at', '>=', $date);
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

