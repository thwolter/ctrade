<?php

namespace App\Services;


use App\Services\Metrics\PortfolioMetricService;

class ChartService
{

    protected $metrics;


    public function __construct(PortfolioMetricService $metrics)
    {
        $this->metrics = $metrics;
    }


    public function midget($portfolio)
    {
        $chart = app()->chartjs
            ->name('midget'.$portfolio->id)
            ->type('line')
            ->size(['width' => 100, 'height' => 100])
            ->labels([1,1,1,1,1,1])
            ->datasets([
                [
                    'backgroundColor'   => '#80aee1',
                    'borderColor'       => '#80aee1',
                    'borderWidth'       => 5,
                    'fill'              => false,
                    'pointRadios'       => 0,
                    'data'              => $this->metrics->valueHistory($portfolio, 5)
                ]
            ])
            ->options([])
            ->optionsRaw([
                'legend' => ['display'   => false,],
                'xAxes' => [
                    'gridLines' => ['display' => false]
                ]
            ]);

        return $chart;
    }
}