<?php

namespace App\Services;


use MathPHP\Statistics\Descriptive;
use MathPHP\Probability\Distribution\Continuous;


class RiskService
{

    public function singleVaR($x, $confidence, $period)
    {
        return Descriptive::standardDeviation($this->logReturn($x)) * $this->inverseCdf($confidence) * sqrt($period);
    }


    /**
     * Calculates the log-returns of an one-dimensional time-series.
     *
     * @param array $x
     * @return array
     */
    public function logReturn(array $x)
    {
        $result = [];
        for ($i = 0; $i < count($x)-1; $i++) {
            $result[] = log($x[$i] / $x[$i+1]);
        }
        return $result;
    }

    /**
     * Calculates the confidence scaling factor.
     *
     * @param float $confidence
     * @return float
     */
    private function inverseCdf($confidence)
    {
        $standardNormal = new Continuous\StandardNormal();

        return $standardNormal->inverse($confidence);
    }


}