<?php

namespace App\Services\Metrics;

use App\Entities\Portfolio;


class PortfolioMetricsService
{

    private $withDate;


    public function withDate()
    {
        $this->withDate = true;
    }


    private function returnWithDate

    public function value(Portfolio $portfolio)
    {
        return array_first($this->getValues($portfolio));
    }


    public function valueHistory(Portfolio $portfolio, $days)
    {
        $a=1;
        return array_slice($this->getValues($portfolio), -$days, $days, true);
    }


    public function risk(Portfolio $portfolio)
    {
        return $this->dailyRisk($portfolio) * sqrt($this->getPeriod($portfolio));
    }


    public function riskHistory(Portfolio $portfolio, $days)
    {
        return array_slice($this->getRisks($portfolio), -$days, $days, true);
    }


    public function dailyRisk(Portfolio $portfolio)
    {
        return array_last($this->getRisks($portfolio));
    }

    // todo: to update
    public function riskToDate($date = null)
    {
        $risk = $this->portfolio->keyFigure('risk')->value;
        $referenceDate = $this->portfolio->keyFigure('risk')->date;
        $dailyRisk = array_get($risk, (string)$this->confidence);

        $period = $date ? $referenceDate->diffInDays($date, false) : $this->period;

        return $dailyRisk * sqrt(max(0, $period));
    }




    // todo: to update
    public function profit($days = null, $percent = false)
    {
        $days = $days ?? $this->period;

        $values = array_reverse(
            array_values($this->portfolio->keyFigure('value')->values)
        );

        if ($values === []) return null;

        if (array_has($values, 0) && array_has($values, $days)) {
            $valueAbsolute = $values[0] - $values[$days];
            $valuePercent = $valueAbsolute / $values[$days];
        } else {
            $valueAbsolute = $valuePercent = null;
        }

        return $percent ? $valuePercent : $valueAbsolute;
    }



    private function getConfidence($portfolio)
    {
        return trim($portfolio->settings('confidence'), '0.');
    }


    private function getPeriod($portfolio)
    {
        return $portfolio->settings('period');
    }


    private function getValues($portfolio)
    {
        return $portfolio->keyfigures()->ofType('value')->first()->values;
    }


    private function getRisks($portfolio)
    {
        return $portfolio->keyfigures()
            ->ofType('risk.'.$this->getConfidence($portfolio))->first()->values;
    }
}