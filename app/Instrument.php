<?php


namespace App;


use App\Repositories\Contracts\InstrumentInterface;
use Illuminate\Database\Eloquent\Model;


abstract class Instrument extends Model implements InstrumentInterface
{

    protected $blade;


    abstract public function financial();


    public function blade()
    {
        return $this->blade;
    }


    public function positions()
    {
        return $this->morphMany('App\Position', 'positionable');
    }


    public function price()
    {
        return $this->financial()->price;
    }

    public function name()
    {
        return $this->financial()->name;
    }

    public function summary()
    {
        // TODO: Implement summary() method.
    }

    public function symbol()
    {
        return $this->financial()->symbol;
    }

    public function type()
    {
        return $this->financial()->type;
    }

    public function currency()
    {
        return $this->financial()->currency;
    }
}