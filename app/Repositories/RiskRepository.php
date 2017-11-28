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
        $risks = $this->portfolio->keyFigure('risk')->values;
        $referenceDate = Carbon::parse(array_last(array_keys($risks)));
        $dailyRisk = array_get(array_last($risks), (string)$this->confidence);

        if (is_null($date)) {
            $factor = sqrt($this->period);

        } else {
            $factor = sqrt(max(
                0,
                $referenceDate->diffInDays($date, false))
            );
        }

        return $dailyRisk * $factor;
    }


    public function portfolioValue($date = null)
    {
        return array_last($this->portfolio->keyFigure('value')->values);
    }

    public function portfolioReturn()
    {
        return null;
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