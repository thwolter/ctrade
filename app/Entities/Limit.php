<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\Limit
 *
 * @property int $id
 * @property int $portfolio_id
 * @property int $type_id
 * @property float $limit
 * @property string $date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Entities\Portfolio $portfolio
 * @property-read \App\Entities\LimitType $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Limit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Limit whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Limit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Limit whereLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Limit wherePortfolioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Limit whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Limit whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Limit extends Model
{
    protected $fillable = ['type', 'limit', 'date'];


    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }


    public function type() {
        return $this->belongsTo(LimitType::class);
    }


    public function toArray()
    {
        return [$this->updated_at->toDateString() => $this->limit];
    }

}
