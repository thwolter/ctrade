<?php

namespace App\Repositories;

use App\Repositories\Exceptions\FinancialException;

trait Financable
{
    
    protected static $financialInstance;


 
    public function financial()
    {
        if (! $this->financial or ! class_exists($this->financial)) {
            
            throw new FinancialException("property financial = '{$this->financial}' doesn't exist.");
        }
        
        if (! isset(static::$financialInstance)) {
            
            static::$financialInstance = new $this->financial;
        }
        
        return static::$financialInstance;
        
    }
}