<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\Category
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Portfolio[] $portfolios
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Category whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Category whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = ['name'];


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public static function getNamesArray($userId)
    {
        $array = [];
        foreach (self::whereUserId($userId)->get() as $category)
        {
            $array[] = $category->name;
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

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
