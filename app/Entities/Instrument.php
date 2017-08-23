<?php


namespace App\Entities;


use App\Exceptions\InstrumentException;
use App\Repositories\Contracts\InstrumentInterface;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use App\Repositories\Financable;

use App\Models\QuantModel;


abstract class Instrument extends Model
{
    
    use Financable;

    public function positions()
    {
        return $this->morphMany(Position::class, 'positionable');
    }


    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }


    public function currencyCode()
    {
        return $this->currency->code;
    }


    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }


    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }
    
    
    public function datasources()
    {
        return $this->morphToMany(Datasource::class, 'sourcable')->withTimestamps();
    }
}