<?php


namespace App\Models\Rscript;

use App\Models\Exceptions\RscriptException;


trait Rscriptable
{
    protected $rscriptInstance;


    public function rscript()
    {

        if (!$this->rscriptable or !class_exists($this->rscriptable)) {

            throw new RscriptException("'rscript' property ({$this->rscriptable}) doesn't exist.");
        }


        if (!isset($this->rscriptInstance)) {

            $this->rscriptInstance = new $this->rscriptable($this);
        }


        return $this->rscriptInstance;

    }
}
