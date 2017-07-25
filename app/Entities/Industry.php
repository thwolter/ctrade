<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\Industry
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Stock[] $stocks
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Industry whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Industry whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Industry whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Industry whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Industry extends Model
{
    protected $fillable = [
        'name'
    ];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
