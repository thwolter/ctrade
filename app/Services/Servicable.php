<?php

namespace App\Services;

use App\Exceptions\ServiceException;

trait Servicable
{

    /**
     * The instance of the presenter.
     *
     * @var $serviceInstance
     */
    private $serviceInstance;


    public function service()
    {
        if (!$this->service or !class_exists($this->service)) {
            throw new ServiceException("'service' property not defined.");
        }

        if (!isset($this->serviceInstance)) {
            $this->serviceInstance = new $this->service($this);
        }

        return $this->serviceInstance;
    }
}