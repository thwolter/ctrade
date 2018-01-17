<?php

namespace App\Services\MetricServices;

use App\Classes\Output\Percent;
use App\Classes\Output\Price;
use App\Facades\Repositories\KeyfigureRepository;
use App\Facades\RiskService\RiskService;
use Carbon\Carbon;
use App\Entities\Portfolio;
use App\Facades\MetricService\AssetMetricService;


class PortfolioMetricService extends MetricService
{

    /**
     * Calculates the Portfolio's value based on latest available price data.
     *
     * @param Portfolio $portfolio
     * @return Price
     */
    public function value(Portfolio $portfolio)
    {
        list($value, $date) = $this->valueStocks($portfolio);
        $total = $value + $this->cash($portfolio)->getValue();

        return new Price($date, $total, $portfolio->currency->code);
    }

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
     * Return the risk for the portfolio's confidence level.
     *
     * @param Portfolio $portfolio
     * @return Price
     * @throws \Exception
     */
    public function risk(Portfolio $portfolio)
    {
        $risk = 0;

        if ($portfolio->assets->count()) {

            $dailyRisk = $this->dailyRisk($portfolio);
            $risk = $dailyRisk * sqrt($portfolio->settings('period'));
        }

        return new Price(Carbon::now()->toDateString(), $risk, $portfolio->currency->code);
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
        $parameter = $portfolio->settings()->only(['confidence', 'period']);

        return RiskService::portfolioVaR($portfolio, $parameter);
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
     * Return the Portfolio's cash position at a given date.
     *
     * @param Portfolio $portfolio
     * @param null $date
     * @return Price
     */
    public function cash(Portfolio $portfolio, $date = null)
    {
        $date = $date ? Carbon::parse($date) : Carbon::now();

        $cash = $portfolio->payments()
            ->where('executed_at', '<=', $date->endOfDay())
            ->sum('amount');

        return new Price($date, $cash, $portfolio->currency->code);
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
     * Return the absolute delta for an array with two values.
     *
     * @param $values
     * @param $days
     * @return float|null
     */
    private function deltaAbsolute($values)
    {
        return array_last($values) - array_first($values);
    }


    /**
     * Return the percentage delta for an array with two values.
     *
     * @param $values
     * @param $days
     * @return float|null
     */
    private function deltaPercent($values)
    {
        return $this->deltaAbsolute($values) / array_first($values);
    }

}