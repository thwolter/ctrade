<?php

namespace App\Repositories;

use App\Repositories\Exceptions\FinancialException;

trait Financable
{
    
    protected $financialInstance;

 
    public function financial()
    {
        if (!method_exists($this, 'datasources')) {
            throw new FinancialException("Method 'datasources' not found.");
        }

        if (! isset($financialInstance)) {
            $this->financialInstance = new DataRepository($this->datasources->first());
        }
        
        return $this->financialInstance;
        
    }

    public function type()
    {
        return $this->financial()->type();
    }


    public function price()
    {
        return $this->financial()->price();
    }


    public function history($dates = null)
    {
        return $this->financial()->history($dates);
    }
}