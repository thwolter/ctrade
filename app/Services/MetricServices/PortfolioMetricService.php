<?php

namespace App\Services\MetricServices;

use Carbon\Carbon;
use App\Entities\Portfolio;


class PortfolioMetricService extends MetricService
{

    public function total(Portfolio $portfolio, $class = null)
    {
        return null;
    }

    public function cash()
    {
        return null;
    }

    public function value(Portfolio $portfolio)
    {
        return $this->shapeOutput(
            array_splice($this->getValues($portfolio), -1, 1, true)
        );
    }


    public function valueHistory(Portfolio $portfolio, $days)
    {
        return array_slice($this->getValues($portfolio), -$days, $days, true);
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


    public function dailyRisk(Portfolio $portfolio)
    {
        return $this->shapeOutput(
            array_slice($this->getRisks($portfolio), -1, 1, true)
        );
    }

    
    public function riskToDate($date = null)
    {
        $referenceDate = $this->getRiskDate($portfolio);
        $period = $date 
            ? $referenceDate->diffInDays($date, false) 
            : $this->getPeriod($portfolio);

        return sqrt(max(0, $period)) * $this->dailyRisk($portfolio);
    }


    public function profit(Portfolio $portfolio, $days = null, $percent = false)
    {
        $values = $this->valueHistory($portfolio, 1 + ($days || $this->getPeriod($portfolio)));

        return $percent ? $this->deltaPercent($values, $days) : $this->deltaAbsolute($days, $values);
    }


    private function getValues($portfolio)
    {
        return $this->toArray($portfolio->keyfigure('value'));
    }



    private function getRisks($portfolio)
    {
        return $this->toArray(
            $portfolio->keyfigure('risk.' . $this->getConfidence($portfolio))
        );
    }
    

    private function getRiskDate($portfolio)
    {
        return Carbon::parse(array_last(array_keys($this->getRisks($portfolio))));
    }


    private function deltaAbsolute($values, $days)
    {
        return count($values) === $days ? array_last($values) - array_first($values) : null;
    }


    private function deltaPercent($values, $days)
    {
        if (!array_first($values)) return null;

        return count($values) === $days ? $this->deltaAbsolute($values, $days) / array_first($values) : null;
    }

}