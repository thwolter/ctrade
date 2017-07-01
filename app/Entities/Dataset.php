<?php

namespace App\Entities;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\Dataset
 *
 * @property int $id
 * @property string $code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Dataset whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Dataset whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Dataset whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Dataset whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Dataset extends Model
{
    protected $fillable = [
        'code'
    ];

   

}
