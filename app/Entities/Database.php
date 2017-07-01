<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\Database
 *
 * @property int $id
 * @property string $code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Database whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Database whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Database whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Database whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Database extends Model
{
    protected $fillable = [
        'code'
    ];
    
}
