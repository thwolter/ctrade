<?php

namespace App\Services\RiskService;

use App\Classes\Output\Price;
use App\Exceptions\RiskServiceException;
use MathPHP\Probability\Distribution\Continuous;
use MathPHP\Statistics\Descriptive;

trait RiskHelperTrait
{

    /**
     * Return risk scaled by time and confidence intervall.
     *
     * @param float $risk
     * @param array $parameter
     * @return float|int
     */
    public function scaleRisk($risk, $parameter)
    {
        $factor = $this->inverseCdf($parameter['confidence']) * sqrt($parameter['period']);

        return $risk * $factor;
    }


    /**
     * Calculates the log-returns of an one-dimensional time-series.
     *
     * @param array $x
     * @return array
     */
    protected function logReturn(array $x)
    {
        $values = array_values($x);
        $keys = array_keys($x);

        $result = [];
        for ($i = 0; $i < count($values) - 1; $i++) {
            $result[] = log($values[$i] / $values[$i + 1]);
        }

        $newKeys = array_slice($keys, 0, count($keys) - 1);
        return array_combine($newKeys, $result);
    }


    /**
     * Calculates the daily standard deviation of an time series based on log-returns.
     *
     * @param array $x
     * @return number
     */
    protected function standardDeviation(array $x)
    {
        return Descriptive::standardDeviation($x);
    }


    /**
     * Calculates the confidence scaling factor.
     *
     * @param float $confidence
     * @return float
     */
    protected function inverseCdf($confidence)
    {
        $standardNormal = new Continuous\StandardNormal();

        return $standardNormal->inverse($confidence);
    }

    /**
     * Throws and exception if confidence and period are not specified in parameters array.
     *
     * @param array $parameter
     * @param array $required
     * @throws \Throwable
     */
    protected function checkParameter($parameter, $required)
    {
        throw_unless(array_has($parameter, $required),
            new RiskServiceException('Parameters missing. ' .
                'Required: ' . implode(',', $required) .
                '. Given: ' . implode(',', array_keys($parameter))));
    }
}