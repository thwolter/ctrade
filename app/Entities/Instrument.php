<?php


namespace App\Entities;


use App\Entities\Exceptions\InstrumentException;
use App\Repositories\Contracts\InstrumentInterface;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use App\Repositories\Financable;

use App\Models\QuantModel;


abstract class Instrument extends Model
{

    protected $financial;
    
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
    
    
    public function datasources()
    {
        return $this->morphToMany(Datasource::class, 'sourcable')->withTimestamps();
    }

    
    public function type()
    {
        return $this->financial()->type();
    }


    public function price()
    {
        return $this->financial()->price();
    }


    public function history($parameter = ['limit' => 250])
    {
        return $this->financial()->history($parameter);
    }


    public function ValueAtRisk()
    {
        return QuantModel::ValueAtRisk($this->history(['limit' => 250]));
    }

    public function percentRisk()
    {
        return array_first($this->price()) / $this->ValueAtRisk();
    }
   

}