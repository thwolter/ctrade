<?php


namespace App\Repositories;


use App\Entities\Portfolio;

class FigureRepository
{

    protected $portfolio;

    protected $confidence;
    protected $period;


    public function __construct(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
        $this->parameters();
    }


    public function value()
    {
        return $this->portfolio->keyfigures()->ofType('value')->first()->value;
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


    private function parameters()
    {
        $this->confidence = $this->portfolio->settings('confidence');
        $this->period = $this->portfolio->settings('period');
    }
}