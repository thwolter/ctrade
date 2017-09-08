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
        if (!isset($financialInstance)) {
            $this->financialInstance = new DataRepository($this->useDatasource());
        }
        return $this->financialInstance;
    }


    public function __call($name, $arguments)
    {
        if (method_exists(DataRepository::class, $name)) {
            return call_user_func_array([$this->financial(), $name], $arguments);
        }

        return parent::__call($name, $arguments);

    }


}