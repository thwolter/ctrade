<?php


namespace App\Entities;


use App\Repositories\Contracts\InstrumentInterface;
use App\Repositories\FinancialRepository;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;


abstract class Instrument extends Model implements InstrumentInterface
{

    use FormAccessible;


    protected $blade;


    /**
     * Kind class has to define the concrete Financial Repository to be injected into the Instrument class
     *
     * @return FinancialRepository
     */
    abstract public function financial();


    public function positions()
    {
        return $this->morphMany('App\Entities\Position', 'positionable');
    }


    public function price()
    {
        return $this->financial()->price;
    }

    public function formPriceAttribute($value)
    {
        return currency_format($value, $this->currency());
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