<?php

namespace App\Entities;

use App\Repositories\Financable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\CcyPair
 *
 * @property int $id
 * @property string $origin
 * @property string $target
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Datasource[] $datasources
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\CcyPair whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\CcyPair whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\CcyPair whereOrigin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\CcyPair whereTarget($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\CcyPair whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CcyPair extends Model
{

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = ['origin', 'target'];


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    public function datasources()
    {
        return $this->morphToMany(Datasource::class, 'sourcable')->withTimestamps();
    }


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */


    public function symbol()
    {
        return $this->origin.$this->target;
    }


    public function datasource()
    {
        return $this->datasources->first();
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeWhereSymbol($query, $symbol)
    {
        return $query
            ->whereOrigin(substr($symbol, 0, 3))
            ->whereTarget(substr($symbol, strlen($symbol)-3), strlen($symbol));
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
