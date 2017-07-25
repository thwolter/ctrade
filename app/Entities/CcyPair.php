<?php

namespace App\Entities;

use App\Entities\Datasource;
use App\Repositories\Financable;
use App\Repositories\DataRepository;
use App\Repositories\Quandl\Quandldata;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\CcyPair
 *
 * @property int $id
 * @property string $origin
 * @property string $target
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Datasource[] $datasources
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\CcyPair whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\CcyPair whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\CcyPair whereOrigin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\CcyPair whereTarget($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\CcyPair whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CcyPair extends Model
{

    use Financable;
    

    protected $financial = DataRepository::class;

    protected $fillable = ['origin', 'target'];


    public function datasources()
    {
        return $this->morphToMany(Datasource::class, 'sourcable')->withTimestamps();
    }


    public function symbol()
    {
        return $this->origin.$this->target;
    }


    public function history()
    {
        return $this->financial()->history();
    }


    public function price()
    {
        return $this->financial()->price();
    }
}
