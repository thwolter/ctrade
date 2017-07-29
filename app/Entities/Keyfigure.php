<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\Keyfigure
 *
 * @property int $id
 * @property int $portfolio_id
 * @property int $key_id
 * @property int $date_id
 * @property float $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Entities\KeyfigureDate $date
 * @property-read \App\Entities\KeyfigureType $key
 * @property-read \App\Entities\Portfolio $portfolio
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Keyfigure whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Keyfigure whereDateId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Keyfigure whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Keyfigure whereKeyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Keyfigure wherePortfolioId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Keyfigure whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Keyfigure whereValue($value)
 * @mixin \Eloquent
 */
class Keyfigure extends Model
{

    protected $fillable = ['values', 'expires_at'];

    protected $casts = [
        'values' => 'json'
    ];


    public function type()
    {
        return $this->belongsTo(KeyfigureType::class);
    }

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }


    public function get($key)
    {
        return array_get($this->values, $key);
    }

    public function set($key, $value)
    {
        $values = $this->values;
        $values[$key] = $value;

        $this->update(['values' => $values, 'expires_at' => null]);
    }

    public function validUntil(Carbon $date)
    {
        $this->update(['expires_at' => $date->toDateTimeString()]);
    }

    public function has($key)
    {
        return array_key_exists($key, $this->values);
    }

    /**
     * Return the start date for calculations as the latest date of already calculated values.
     *
     * @param KeyFigure
     * @return Carbon
     */
    public function calculateFromDate()
    {
        $date = $this->portfolio->created_at;

        if (count($this->values) > 0) {
            $date = Carbon::parse(max(max(array_keys($this->values)), $date))->addDay();

            $invalidated = $this->expires_at;
            if (!is_null($invalidated)) {
                $date = Carbon::parse(min($date, $invalidated));
            }
        }
        return $date->endOfDay();
    }


    public static function boot()
    {
        parent::boot();
        static::creating(function($keyfigures) {
            $keyfigures->values = [];
        });
    }
}
