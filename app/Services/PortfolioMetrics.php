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
        return optional($this->portfolio->keyfigures()->ofType('value')->first())->value;
    }


    public function risk()
    {
        return $this->dailyRisk() * sqrt($this->period);
    }


    public function dailyRisk()
    {
        $riskArray = $this->portfolio->keyfigures()->ofType('risk')->first()->value;

        return array_get($riskArray, (string)$this->confidence);
    }



}