<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\KeyfigureType
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Keyfigure[] $keyFigures
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\KeyfigureType whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\KeyfigureType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\KeyfigureType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\KeyfigureType whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\KeyfigureType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class KeyfigureType extends Model
{

    protected $fillable = ['code', 'name'];


    public function keyFigures()
    {
        return $this->hasMany(Keyfigure::class);
    }
}
