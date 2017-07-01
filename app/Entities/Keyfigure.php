<?php

namespace App\Entities;

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

    protected $fillable = ['value'];

    public function key()
    {
        return $this->belongsTo(KeyfigureType::class);
    }

    public function date()
    {
        return $this->belongsTo(KeyfigureDate::class);
    }

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    /**
     * @param $key
     * @param $value
     * @param $date
     * @return Keyfigure
     */
    static public function set($key, $value, $date)
    {
        $keyFigure = new self(['value' => $value]);

        $keyFigure->key()->associate(KeyfigureType::firstOrCreate(['code' => $key]));
        $keyFigure->date()->associate(KeyfigureDate::firstOrCreate(['date' => $date]));

        return $keyFigure;
    }
}
