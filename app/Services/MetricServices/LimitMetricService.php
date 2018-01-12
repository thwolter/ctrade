<?php


namespace App\Services\MetricServices;

use App\Classes\Limits\LimitEnhancer;
use App\Classes\Output\Percent;
use App\Classes\Output\Price;


class LimitMetricService extends MetricService
{
    use LimitEnhancer;

    /**
     * @param $limit
     * @return Price|Percent
     */
    public function utilisation($limit)
    {
        return $this->enhance($limit)->utilisation();
    }

    /**
     * @param $limit
     * @return Price|Percent
     */
    public function value($limit)
    {
        return $this->enhance($limit)->value();
    }

}
