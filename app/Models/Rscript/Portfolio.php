<?php


namespace App\Models\Rscript;


use Illuminate\Support\Facades\Storage;

class Portfolio extends Rscripter
{


    /**
     * @param int $history the number of historical days for parameter estimation
     * @param double $conf the VaR confidence level
     * @param int $period the VaR period
     *
     * @return array $res with calculated risk results
     */
    public function risk($history, $conf, $period)
    {
        $res = $this->callRscript([
            'task' => 'risk',
            'conf' => $conf,
            'period' => $period,
            'hist' => $history
        ]);

        return $res;
    }

}