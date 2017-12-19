<?php


namespace App\Classes\Limits;

use App\Entities\Limit;

abstract class AbstractLimit
{
    protected $limit;
    protected $metrics;


    public function __construct(Limit $limit)
    {
        $this->limit = $limit;
    }

    abstract public function utilisation();
}