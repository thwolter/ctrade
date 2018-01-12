<?php


namespace App\Classes\Limits;


use App\Classes\Output\Percent;
use App\Classes\Output\Price;
use App\Facades\MetricService\PortfolioMetricService;

class AbsoluteLimit extends AbstractLimit
{

    public function utilisation()
    {
        $risk = PortfolioMetricService::risk($this->limit->portfolio)->getValue();

        return new Percent($this->limit->date, $risk / $this->limit->value);
    }


    public function value()
    {
        return new Price($this->limit->date, $this->limit->value, $this->limit->portfolio->currency->code);
    }


    public function description()
    {
        return 'Das Absolute Limit soll den Verlust in deines Portfolio in einem festen Betrag beschränken.';
    }


    public function title()
    {
        return 'Absolutes Limit';
    }
}