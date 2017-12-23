<?php

namespace App\Services\RscriptService;


use Illuminate\Support\Facades\Log;


class RscriptService extends BaseRscript
{

    /**
     * @param $portfolio
     * @param $date
     *
     * @return array
     * @throws \App\Exceptions\RscriptException
     */
    public function portfolioRisk($portfolio, $date)
    {
        Log::info(("Calculate risk for portfolio {$portfolio->id} on {$date}"));
        $script = 'Risk.R';

        $args = [
            'id' => $portfolio->id,
            'date' => $date,
            'count' => $portfolio->settings('history')
        ];

        return $this->execute($portfolio, $script, $args);
    }


    /**
     * @param $portfolio
     * @param $date
     *
     * @return array
     * @throws \App\Exceptions\RscriptException
     */
    public function portfolioValue($portfolio, $date)
    {
        Log::info(("Calculate value for portfolio {$portfolio->id} on {$date}"));
        $script = 'Value.R';

        $args = [
            'id' => $portfolio->id,
            'date' => $date
        ];

        return $this->execute($portfolio, $script, $args);
    }


    public function stockRisk($portfolio, $date)
    {
        return ['2010-10-10' => 0];
    }
}