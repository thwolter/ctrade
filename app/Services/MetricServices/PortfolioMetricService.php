<?php

namespace App\Services\MetricServices;

use App\Classes\Output\Percent;
use App\Classes\Output\Price;
use App\Entities\Portfolio;
use App\Facades\MetricService\AssetMetricService;
use App\Facades\Repositories\KeyfigureRepository;
use App\Facades\RiskService\RiskService;


class PortfolioMetricService extends MetricService
{


    /**
     * @param Portfolio $portfolio
     * @return array
     */
    public function valueStocks(Portfolio $portfolio)
    {
        $value = 0;
        $date = null;

        foreach ($portfolio->assets as $asset) {
            $assetValue = AssetMetricService::value($asset);
            $value += $assetValue->getValue();

            $date = max($date, $assetValue->getDate());
        }
        return array($value, $date);
    }


    /**
     * Return the Portfolio's profit over a specified period.
     *
     * @param Portfolio $portfolio
     * @param null $count
     * @param bool $percent
     * @return Percent|Price
     */
    public function profit(Portfolio $portfolio, $count = null, $percent = false)
    {
        $values = KeyfigureRepository::getForPortfolio($portfolio, 'value')->timeseries()
            ->count(1 + ($count || $this->getPeriod($portfolio)))->get();

        if (count($values) != $count) return null;

        return $percent
            ? new Percent(key($values), $this->deltaPercent($values))
            : new Price(key($values), $this->deltaAbsolute($values), $portfolio->currency->code);
    }

    /**
     * Return the percentage delta for an array with two values.
     *
     * @param $values
     * @return float|null
     */
    private function deltaPercent($values)
    {
        return $this->deltaAbsolute($values) / array_first($values);
    }

    /**
     * Return the absolute delta for an array with two values.
     *
     * @param $values
     * @return float|null
     */
    private function deltaAbsolute($values)
    {
        return array_last($values) - array_first($values);
    }

    public function cashFlow(Portfolio $portfolio, $from, $to)
    {
        return $portfolio->payments()
            ->whereBetween('executed_at', [$from, $to])->sum('amount');
    }

    public function totalOfType(Portfolio $portfolio, $type)
    {
        $sum = 0;
        foreach ($portfolio->assets()->ofType($type)->get() as $asset) {
            $sum += $asset->value();
        }
        return $sum;
    }


    public function riskHistory(Portfolio $portfolio, $days)
    {
        return array_slice($this->getRisks($portfolio), -$days, $days, true);
    }


    public function riskToDate(Portfolio $portfolio, $date = null)
    {
        $referenceDate = $this->getRiskDate($portfolio);
        $period = $date
            ? $referenceDate->diffInDays($date, false)
            : $this->getPeriod($portfolio);

        return sqrt(max(0, $period)) * $this->dailyRisk($portfolio);
    }

    /**
     * Return the Portfolio's risk as latest value stored in the database.
     *
     * @param Portfolio $portfolio
     * @return float
     *
     * @throws \Exception
     */
    private function dailyRisk(Portfolio $portfolio)
    {
        return RiskService::portfolioVaR($portfolio, $portfolio->riskParameter());
    }

}