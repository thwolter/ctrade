<?php

namespace App\Repositories;

use App\Entities\Datasource;
use App\Repositories\Exceptions\FinancialException;

trait Financable
{
    
    protected $financialInstance;


    abstract protected function useDatasource();


    public function financial()
    {
        if (! isset($financialInstance)) {

            $this->financialInstance = new DataRepository($this->useDatasource());
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