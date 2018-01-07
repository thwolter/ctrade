<?php

namespace App\Services\RiskService;

use App\Entities\Asset;
use App\Entities\Portfolio;
use App\Exceptions\RiskServiceException;
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


    /**
     * Returns the Value-at-Risk for a given asset and specified confidence level and period.
     *
     * @param Asset $asset
     * @param array $parameter
     * @return mixed
     * @throws \Throwable
     */
    public function VaR(Asset $asset, $parameter)
    {
        $this->checkConfidenceAndPeriod($parameter);

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
        $parameter = $this->parameterOrDefault($portfolio, $parameter);

        $returns = $this->getPortfolioLogReturns($portfolio, $parameter);

        $C = new Matrix($this->covarianceMatrix($returns));
        $V = new Vector($this->deltaVector($portfolio, $parameter));

        return $this->scaleRisk($this->multiplyVCV($V, $C), $parameter);
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
       foreach ($portfolio->assets as $asset) {
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
        return sqrt($V->dotProduct($C->vectorMultiply($V)));
    }


    /**
     * Throws and exception if confidence and period are not specified in parameters array.
     *
     * @param $parameter
     * @throws \Throwable
     */
    private function checkConfidenceAndPeriod($parameter)
    {
        throw_unless(array_has($parameter, ['confidence', 'period']),
            new RiskServiceException("Parameters 'confidence' and/or 'period' missing"));
    }


    /**
     * Returns the parameter filled with default settings where required.
     *
     * @param Portfolio $portfolio
     * @param array $parameter
     * @return array
     */
    private function parameterOrDefault($portfolio, $parameter)
    {
        return array_merge($portfolio->settings()->only(['period', 'confidence']), $parameter);
    }
}