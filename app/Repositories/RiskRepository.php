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


    public function portfolioReturn()
    {
        $values = $this->portfolio->keyFigure('value')->values;
        if (!$values) return null;

        $dates = array_keys($values);

        $now = Carbon::now()->toDateString();
        $from = Carbon::now()->subDay($this->returnPeriod)->toDateString();

        if (! array_key_exists($now, array_keys($values))) {
            $now = array_last($dates);
        }

        if (! array_key_exists($from, array_keys($values))) {
            $from = array_first($dates);
        }
        //todo: eliminate all cash in/out before calculating return
        $return = $values[$now]-$values[$from];

        return $return;
    }
}