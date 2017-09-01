<?php

namespace App\Entities;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

/**
 * App\Entities\Sector
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Stock[] $stocks
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Sector whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Sector whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Sector whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Sector whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Sector extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'name', 'name_de'
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

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    public function getNameAttribute($value)
    {
        return (App::getLocale('de') && $this->name_de) ? $this->name_de : $value;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */


}
