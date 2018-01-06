<?php

namespace App\Services\RiskService;

use App\Entities\Asset;
use App\Entities\Portfolio;
use Carbon\Carbon;
use MathPHP\LinearAlgebra\Matrix;
use MathPHP\LinearAlgebra\Vector;
use MathPHP\Statistics\Correlation;
use App\Facades\PortfolioService;


class RiskService
{
    use RiskHelperTrait;


    private $register = [
        'Stock' => StockRisk::class
    ];


    public function VaR(Asset $asset, $parameter = [])
    {
        $type = class_basename($asset->positionable);
        return resolve($this->register[$type])->VaR($asset, $parameter);
    }


    /**
     * @param Portfolio $portfolio
     * @param array $parameter
     * @return float|int
     *
     * @throws \Exception
     */
    public function portfolioVaR($portfolio, $parameter = [])
    {
        $confidence = array_get($parameter, 'confidence', $portfolio->settings('confidence'));
        $period = array_get($parameter, 'period', $portfolio->settings('period'));

        $returns = $this->getPortfolioLogReturns($portfolio, $parameter);

        $C = new Matrix($this->covarianceMatrix($returns));
        $V = new Vector($this->deltaVector($portfolio, $parameter));

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
     * @param array $parameter
     *
     * @return array
     * @throws \Exception
     */
    private function deltaVector(Portfolio $portfolio, $parameter)
    {
       foreach ($portfolio->assets as $asset)
        {
            $delta[] = $this->delta($asset, $parameter);
        }
        return $delta;
    }


    /**
     * Return the asset's delta.
     *
     * @param $asset
     * @return mixed
     */
    private function delta($asset, $parameter)
    {
        $type = class_basename($asset->positionable);
        return resolve($this->register[$type])->delta($asset, $parameter);
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