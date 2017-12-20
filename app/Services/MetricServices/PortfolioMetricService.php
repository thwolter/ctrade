<?php

namespace App\Services\MetricServices;

use App\Classes\Price;
use App\Classes\TimeSeries;
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

        foreach ($portfolio->assets as $asset)
        {
            $assetValue = AssetMetricService::value($asset);
            $value =+ array_first($assetValue);

            $assetValueDate = Carbon::parse(key($assetValue));
            $date = max($date, $assetValueDate);
        }

        return new Price($date, $value + $this->cash($portfolio)->getValue());
    }


    /**
     * Return the Portfolio's profit over a specified period.
     *
     * @param Portfolio $portfolio
     * @param null $count
     * @param bool $percent
     * @return float|int|mixed|null
     */
    public function profit(Portfolio $portfolio, $count = null, $percent = false)
    {
        $values = $this->dataService->dbPortfolioValue($portfolio)
            ->count(1 + ($count || $this->getPeriod($portfolio)))
            ->get();

        return $percent ? $this->deltaPercent($values, $count) : $this->deltaAbsolute($count, $values);
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

        return new Price($date, $cash);
    }






    public function cashFlow(Portfolio $portfolio, $from, $to)
    {
        return $portfolio->payments()
            ->whereBetween('executed_at', [$from, $to])->sum('amount');
    }


    public function totalOfType(Portfolio $portfolio, $type)
    {
        $sum = 0;
        foreach($portfolio->assets()->ofType($type)->get() as $asset)
        {
            $sum += $asset->value();
        }
        return $sum;
    }



    public function risk(Portfolio $portfolio)
    {
        $dailyRisk = $this->withDate()->dailyRisk($portfolio);

        return $this->shapeOutput(
            [key($dailyRisk) => array_first($dailyRisk) * sqrt($this->getPeriod($portfolio))]
        );
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
     * @return Price
     */
    private function dailyRisk(Portfolio $portfolio)
    {
        $value = $this->dataService
            ->dbPortfolioRisk($portfolio, $this->getConfidence($portfolio))
            ->count(1)
            ->get();

        return new Price(key($value), array_first($value));
    }


    /**
     * Receive the Portfolio's risk history from the database.
     *
     * @param $portfolio
     * @return TimeSeries
     */
    private function getDbRisks($portfolio)
    {
        return new TimeSeries($portfolio->keyfigure('risk.' . $this->getConfidence($portfolio))->values);
    }


    /**
     * Return the absolute delta for an array with two values.
     *
     * @param $values
     * @param $days
     * @return mixed|null
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
     * @return float|int|null
     */
    private function deltaPercent($values, $days)
    {
        if (!array_first($values)) return null;

        return count($values) === $days ? $this->deltaAbsolute($values, $days) / array_first($values) : null;
    }

}