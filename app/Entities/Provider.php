<?php

namespace App\Entities;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\Provider
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Datasource[] $datasources
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Provider whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Provider whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Provider whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Provider whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Provider whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Provider extends Model
{
    protected $fillable = [
        'code', 'name'
    ];
    
   public function datasources()
   {
       return $this->hasMany(Datasource::class);
   }
}
