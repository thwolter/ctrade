<?php


namespace App\Models\Rscript;


use Illuminate\Support\Facades\Storage;
use Khill\Lavacharts\Lavacharts;


class Portfolio extends Rscripter
{


    /**
     * @param int $history the number of historical days for parameter estimation
     * @param double $conf the VaR confidence level
     * @param int $horizon the VaR period
     *
     * @return array $res with calculated risk results
     */
    public function risk($history, $conf, $horizon)
    {
        $res = $this->callRscript([
            'task' => 'risk',
            'conf' => $conf,
            'horizon' => $horizon,
            'hist' => $history
        ]);

        return $res;
    }

}