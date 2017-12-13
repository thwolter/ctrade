<?php


namespace App\Services;

use App\Entities\Portfolio;


class PortfolioMetrics
{

    protected $portfolio;

    protected $confidence;
    protected $period;


    public function __construct(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
        $this->setParameters();
    }


    private function setParameters()
    {
        $this->confidence = $this->portfolio->settings('confidence');
        $this->period = $this->portfolio->settings('period');
    }


    public function value()
    {
        $kpi = $this->portfolio->keyfigures()->ofType('value')->first();
        return array_first($kpi->value);
    }


    public function history($days)
    {
        $kpi = $this->portfolio->keyfigures()->ofType('value');
        return array_first($kpi->value);
    }


    public function risk()
    {
        return $this->dailyRisk() * sqrt($this->period);
    }


    public function riskToDate($date = null)
    {
        $risk = $this->portfolio->keyFigure('risk')->value;
        $referenceDate = $this->portfolio->keyFigure('risk')->date;
        $dailyRisk = array_get($risk, (string)$this->confidence);

        $period = $date ? $referenceDate->diffInDays($date, false) : $this->period;

        return $dailyRisk * sqrt(max(0, $period));
    }


    public function dailyRisk()
    {
        $riskArray = $this->portfolio->keyfigures()->ofType('risk')->first()->value;

        return array_get($riskArray, (string)$this->confidence);
    }


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


}