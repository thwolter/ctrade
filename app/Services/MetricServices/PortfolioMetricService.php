<?php

namespace App\Services\MetricServices;

use App\Classes\Price;
use App\Facades\Repositories\KeyfigureRepository;
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
        $value = 0;
        $date = null;

        foreach ($portfolio->assets as $asset) {
            $assetValue = AssetMetricService::value($asset);
            $value += $assetValue->getValue();

            $date = max($date, $assetValue->getDate());
        }

        return Price::make($date, $value + $this->cash($portfolio)->getValue())
            ->setCurrency($portfolio->currency->code);
    }


    /**
     * Return the risk for the portfolio's confidence level.
     *
     * @param Portfolio $portfolio
     * @return Price
     */
    public function risk(Portfolio $portfolio)
    {
        $dailyRisk = $this->dailyRisk($portfolio);

        $value = Price::make(key($dailyRisk), array_first($dailyRisk) * sqrt($this->getPeriod($portfolio)));

        return $value->setCurrency($portfolio->currency->code);
    }


    /**
     * Return the Portfolio's profit over a specified period.
     *
     * @param Portfolio $portfolio
     * @param null $count
     * @param bool $percent
     * @return Price
     */
    public function profit(Portfolio $portfolio, $count = null, $percent = false)
    {
        $values = KeyfigureRepository::getForPortfolio($portfolio, 'value')->timeseries()
            ->count(1 + ($count || $this->getPeriod($portfolio)))->get();

        return $percent
            ? Price::make($this->deltaPercent($values, $count), key($values))->setPercent(true)
            : Price::make($this->deltaAbsolute($count, $values), key($values))->setCurrency($portfolio->currency->code);
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

        return Price::make($date, $cash)->setCurrency($portfolio->currency->code);
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
     * @return array
     */
    private function dailyRisk(Portfolio $portfolio)
    {
        $term = 'risk.' . $this->getConfidence($portfolio);

        return KeyfigureRepository::getForPortfolio($portfolio, $term)->timeseries()->count(1)->get();
    }


    /**
     * Return the absolute delta for an array with two values.
     *
     * @param $values
     * @param $days
     * @return float|null
     */
    private function deltaAbsolute($values, $days)
    {
        return count($values) === $days ? array_last($values) - array_first($values) : null;
    }


    /**
     * Return the percentage delta for an array with two values.
     *
     * @param $values
     * @param $days
     * @return float|null
     */
    private function deltaPercent($values, $days)
    {
        if (!array_first($values)) return null;

        return count($values) === $days ? $this->deltaAbsolute($values, $days) / array_first($values) : null;
    }

}