<?php

namespace App\Services\RscriptService;


use App\Facades\DataService;
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
        if ($this->isEmpty($portfolio)) return null;

        Log::info(("Calculate risk for portfolio {$portfolio->id} on {$date}"));

        $args = [
            'id' => $portfolio->id,
            'date' => $date,
            'count' => $portfolio->settings('history')
        ];

        return $this->execute('Risk.R', $args);
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
        if ($this->isEmpty($portfolio)) return null;

        Log::info(("Calculate value for portfolio {$portfolio->id} on {$date}"));

        $args = [
            'id' => $portfolio->id,
            'date' => $date
        ];

        return $this->execute('Value.R', $args);
    }


    /**
     * @param $stock
     * @param $exchange
     * @return array
     * @throws \App\Exceptions\RscriptException
     */
    public function stockRisk($stock, $exchange)
    {
        $args = [
            'id' => $stock->id,
            'conf' => 0.95
        ];

        return $this->execute('StockRisk.R', $args);
    }


    private function isEmpty($portfolio)
    {
        return $portfolio->positions->count() == 0;
    }
}