<?php


namespace App\Entities;


use App\Repositories\Contracts\InstrumentInterface;
use App\Repositories\FinancialRepository;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;


abstract class Instrument extends Model
{

    protected $financial;
    
    static protected $financialInstance;

 
   
    public function financial()
    {
        if (! $this->financial or ! class_exists($this->financial)) {
            
            throw new FinancialException();
        }
        
        if (! isset(static::$financialInstance)) {
            
            static::$financialInstance = new $this->financial;
        }
        
        return static::$financialInstance;
        
    }
    

    public function positions()
    {
        return $this->morphMany('App\Entities\Position', 'positionable');
    }


    public function price()
    {
        return $this->financial()->price($this->symbol);
    }

   
    public function name()
    {
        return $this->financial()->name($this->symbol);
    }



    public function symbol()
    {
        return $this->symbol;
    }


    public function type()
    {
        return $this->financial()->type();
    }


    public function currency()
    {
        return $this->financial()->currency($this->symbol);
    }
}