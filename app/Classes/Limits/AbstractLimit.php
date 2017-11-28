<?php


namespace App\Classes\Limits;

use App\Entities\Limit;
use App\Repositories\RiskRepository;

abstract class AbstractLimit
{
    protected $limit;
    protected $risk;

    public function __construct(Limit $limit)
    {
        $this->limit = $limit;
        $this->risk = new RiskRepository($this->limit->portfolio);
    }

    abstract public function utilisation();
}