<?php

namespace App\Services;



class ChartService
{

    protected $metrics;


    private function metric($entity)
    {
        return app()->make('MetricService', [$entity]);
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
                    'data'              => $this->metric($portfolio)->valueHistory($portfolio, 5)
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