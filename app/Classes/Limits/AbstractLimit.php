<?php


namespace App\Classes\Limits;

use App\Classes\Output\Percent;
use App\Classes\Output\Price;
use App\Entities\Limit;
use App\Facades\MetricService\PortfolioMetricService;

abstract class AbstractLimit
{
    protected $limit;
    protected $metrics;


    public function __construct(Limit $limit)
    {
        $this->limit = $limit;
    }

    /**
     * @return Percent
     */
    abstract public function utilisation();

    /**
     * @return Price|Percent
     */
    abstract public function value();
}