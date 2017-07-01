<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\KeyfigureDate
 *
 * @property int $id
 * @property string $date
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Keyfigure[] $keyfigures
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\KeyfigureDate whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\KeyfigureDate whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\KeyfigureDate whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\KeyfigureDate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class KeyfigureDate extends Model
{
    protected $fillable = ['date'];

    public function keyfigures()
    {
        return $this->hasMany(Keyfigure::class);
    }
}
