<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\LimitType
 *
 * @property int $id
 * @property string $code
 * @property string|null $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Limit[] $limits
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\LimitType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\LimitType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\LimitType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\LimitType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\LimitType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LimitType extends Model
{

    protected $fillable = ['code', 'name'];


    public function limits()
    {
        return $this->hasMany(Limit::class);
    }
}
