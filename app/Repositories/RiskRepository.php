<?php


namespace App\Repositories;


use App\Entities\Portfolio;
use Carbon\Carbon;

class RiskRepository
{

    protected $portfolio;

    protected $daysPerYear = 250;

    protected $confidence;
    protected $period;
    protected $returnPeriod;


    public function __construct(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;

        $this->confidence = $portfolio->settings('confidence');
        $this->period = $portfolio->settings('period');
        $this->returnPeriod = $portfolio->settings('returnPeriod');
    }


    public function portfolioRisk($date = null)
    {
        $risk = $this->portfolio->keyFigure('risk')->value;
        $referenceDate = $this->portfolio->keyFigure('risk')->date;
        $dailyRisk = array_get($risk, (string)$this->confidence);

        $period = $date ? $referenceDate->diffInDays($date, false) : $this->period;

        return $dailyRisk * sqrt(max(0, $period));
    }


    public function portfolioValue($date = null)
    {
        return $this->portfolio->keyFigure('value')->value;
    }

    public function portfolioReturn()
    {
        return null;
    }

    public function valueChange($days)
    {
        $values = array_values($this->portfolio->keyFigure('value')->values);

        return $values[0] && $values[$days] ? $values[0] - $values[$days] : null;
    }

    public function portfolioProfit()
    {
        return array_get($this->getPortfolioDelta(), 'delta');
    }

    private function getPortfolioDelta()
    {
        $values = $this->portfolio->keyFigure('value')->values;
        if (!$values) return null;

        $dates = array_keys($values);

        $now = Carbon::now()->endOfDay();
        $from = Carbon::now()->subDays($this->returnPeriod)->endOfDay();

        if (!array_key_exists($now->toDateString(), array_keys($values))) {
            $now = Carbon::parse(array_last($dates))->endOfDay();
        }

        if (!array_key_exists($from->toDateString(), array_keys($values))) {
            $from = Carbon::parse(array_first($dates))->endOfDay();
        }

        $cashFlow = $this->portfolio->cashFlow($from, $now);
        $delta = $values[$now->toDateString()] - $values[$from->toDateString()] - $cashFlow;

        return ['from' => $from, 'now' => $now, 'delta' => $delta];
    }
}