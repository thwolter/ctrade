<?php


namespace App\Services\MetricServices;

use App\Classes\Limits\AbstractLimit;
use App\Classes\Output\Output;
use App\Classes\Output\Percent;
use App\Classes\Output\Price;


class LimitMetricService extends MetricService
{

    /**
     * @param $limit
     * @return Price|Percent
     */
    public function utilisation($limit)
    {
        return app(AbstractLimit::class, [$limit])->utilisation();
    }

    /**
     * @param $limit
     * @return Price|Percent
     */
    public function value($limit)
    {
        return app(AbstractLimit::class, [$limit])->value();
    }
}
