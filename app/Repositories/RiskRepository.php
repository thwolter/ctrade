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


    public function __construct(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;

        $this->confidence = $portfolio->settings('confidence');
        $this->period = $portfolio->settings('period');
    }


    public function portfolioRisk($date = null)
    {
        $risks = $this->portfolio->keyFigure('risk')->values;
        $referenceDate = Carbon::parse(key($risks));
        $dailyRisk = array_get(head($risks), (string)$this->confidence);

        if (is_null($date)) {
            $factor = sqrt($this->period);

        } else {
            $factor = sqrt(max(0, $referenceDate->diffInDays($date, false)));
        }

        return $dailyRisk * $factor;
    }
}