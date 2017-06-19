<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

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
