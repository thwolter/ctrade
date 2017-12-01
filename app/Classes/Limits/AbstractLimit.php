<?php


namespace App\Classes\Limits;

use App\Services\PortfolioMetrics;
use App\Entities\Limit;

abstract class AbstractLimit
{
    protected $limit;
    protected $metrics;


    public function __construct(Limit $limit)
    {
        $this->limit = $limit;
        $this->metrics = new PortfolioMetrics($limit->portfolio);
    }

    abstract public function utilisation();
}