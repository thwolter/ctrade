<?php


namespace App\Classes\Limits;

use App\Entities\Limit;
use App\Facades\MetricService\PortfolioMetricService;

abstract class AbstractLimit
{
    protected $limit;
    protected $metrics;


    public function __construct(Limit $limit)
    {
        $this->limit = $limit;

        $this->metrics = new PortfolioMetricService();
    }

    abstract public function utilisation();
}