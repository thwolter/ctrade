<?php


namespace App\Classes\Limits;

use App\Services\MetricServices\PortfolioMetricService;
use App\Entities\Limit;

abstract class AbstractLimit
{
    protected $limit;
    protected $metrics;


    public function __construct(Limit $limit)
    {
        $this->limit = $limit;
        $this->metrics = app()->make(PortfolioMetricService::class);
    }

    abstract public function utilisation();
}