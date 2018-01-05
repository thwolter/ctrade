<?php

namespace App\Services;


use App\Entities\Asset;
use App\Entities\Portfolio;
use App\Facades\MetricService\AssetMetricService;
use Carbon\Carbon;
use MathPHP\LinearAlgebra\Matrix;
use MathPHP\LinearAlgebra\Vector;
use MathPHP\Statistics\Correlation;
use MathPHP\Statistics\Descriptive;
use MathPHP\Probability\Distribution\Continuous;
use App\Facades\PortfolioService;


class RiskService
{


    public function singleVaR($x, $confidence, $period)
    {
        return $this->standardDeviation($x) * $this->inverseCdf($confidence) * sqrt($period);
    }


    /**
     * @param Portfolio $portfolio
     * @param array $parameter
     * @return float|int
     *
     * @throws \Exception
     */
    public function portfolioVaR(Portfolio $portfolio, $parameter = [])
    {
        $confidence = array_get($parameter, 'confidence', $portfolio->settings('confidence'));
        $period = array_get($parameter, 'period', $portfolio->settings('period'));

        $returns = $this->getPortfolioLogReturns($portfolio, $parameter);

        $C = new Matrix($this->covarianceMatrix($returns));
        $V = new Vector($this->deltaVector($portfolio));

        return $this->multiplyVCV($V, $C) * $this->inverseCdf($confidence) * sqrt($period);
    }


    /**
     * Return the Variance-Covariance-Matrix.
     *
     * @param array $returns
     * @return mixed
     */
    private function covarianceMatrix(array $returns)
    {
        $m = array_values($returns);

        for ($i = 0; $i < count($m); $i++) {
            for ($j =  0; $j < count($m); $j++) {
                $corr[$i][$j] = Correlation::covariance(array_values($m[$i]), array_values($m[$j]));
            }
        }
        return $corr;
    }


    /**
     * Return the delta vector for portfolio assets.
     *
     * @param Portfolio $portfolio
     * @return array
     * @throws \Exception
     */
    public function deltaVector(Portfolio $portfolio)
    {
        $delta = [];
        foreach ($portfolio->assets as $asset) {

            $type = class_basename($asset->positionable);
            switch ($type) {
                case 'Stock': $delta[] = $this->stockDelta($asset); break;
                default: throw new \Exception("Cannot calculate delta for $type");
            }
        }

        return $delta;
    }


    /**
     * Return the delta for a stock asset.
     *
     * @param Asset $asset
     * @return mixed
     */
    private function stockDelta(Asset $asset)
    {
        return AssetMetricService::value($asset)->getValue();
    }


    /**
     * Calculates the daily standard deviation of an time series based on log-returns.
     *
     * @param array $x
     * @return number
     */
    private function standardDeviation(array $x)
    {
        return Descriptive::standardDeviation($this->logReturn($x));
    }


    /**
     * Calculates the log-returns of an one-dimensional time-series.
     *
     * @param array $x
     * @return array
     */
    private function logReturn(array $x)
    {
        $values = array_values($x);
        $keys = array_keys($x);

        $result = [];
        for ($i = 0; $i < count($values)-1; $i++) {
            $result[] = log($values[$i] / $values[$i+1]);
        }

        $newKeys = array_slice($keys, 0, count($keys) - 1);
        return array_combine($newKeys, $result);
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

    /**
     * Return the portfolios assets log returns as an array.
     *
     * @param Portfolio $portfolio
     * @param $parameter
     * @return array
     */
    private function getPortfolioLogReturns(Portfolio $portfolio, $parameter)
    {
        $histories = PortfolioService::assetHistories($portfolio, [
            'date' => array_get($parameter, 'date', Carbon::now()->toDateString()),
            'count' => $portfolio->settings('history')
        ]);

        return array_map([$this, 'logReturn'], $histories);
    }

    /**
     * Multiply V^t * C * V.
     *
     * @param $V
     * @param $C
     * @return float
     */
    private function multiplyVCV($V, $C): float
    {
        $stddev = sqrt($V->dotProduct($C->vectorMultiply($V)));
        return $stddev;
    }

}