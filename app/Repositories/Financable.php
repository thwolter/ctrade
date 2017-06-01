<?php

namespace App\Repositories;

use App\Repositories\Exceptions\FinancialException;

trait Financable
{
    
    protected $financialInstance;


 
    public function financial()
    {
        if (! $this->financial or ! class_exists($this->financial)) {
            
            throw new FinancialException("property financial = '{$this->financial}' doesn't exist.");
        }
        
        if (! isset($financialInstance)) {
            
            $this->financialInstance = new $this->financial($this->datasource);
        }
        
        return $this->financialInstance;
        
    }
}