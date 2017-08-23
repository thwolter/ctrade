<?php

namespace App\Entities;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\Currency
 *
 * @property int $id
 * @property string $code
 * @property bool $eligible
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Portfolio[] $portfolios
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Stock[] $stocks
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Currency whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Currency whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Currency whereEligible($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Currency whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Currency whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Currency extends Model
{

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'code', 'elibible'
    ];


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }


    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */


    public static function getEnumValuesAsAssociativeArray($field_name)
    {
        $array = [];
        foreach (self::all() as $item)
        {
            $array[$item->id] = $item->$field_name;
        }
        return $array;
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeEligible($query)
    {
        return $query->where('eligible', 1);
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
