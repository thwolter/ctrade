<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\Role
 *
 * @property int $id
 * @property string $code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Role whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Role whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends Model
{
    public function user()
    {
        $this->belongsToMany(User::class);
    }
}
