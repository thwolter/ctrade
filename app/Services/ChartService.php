<?php

namespace App\Services;


class ChartService
{

    public function __construct()
    {

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
                    'data'              => [1, 3, 2, 5, 2, 7]
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