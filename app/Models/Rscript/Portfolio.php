<?php


namespace App\Models\Rscript;


use Illuminate\Support\Facades\Storage;
use Khill\Lavacharts\Lavacharts;
use App\Repositories\Yahoo\Financial;
use App\Repositories\OandaFinancial;


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
    
    

    public function saveSymbols($directory)
    {
        $symbols = [];

        foreach ($this->entity->positions as $position) {
            $symbol = $position->symbol();
            if (! in_array($symbol, $symbols)) {

                $json = $position->history();
                $filename = "{$directory}/{$symbol}.json";

                Storage::disk('local')->put($filename, $json);
                $symbols[] = $symbol;
            }


            if (! $position->hasCurrency($this->entity->currency())) {
                $symbol = $position->currency() . $this->entity->currency();
                if (!in_array($symbol, $symbols)) {

                    $json = $this->entity->history($position->currency());
                    $filename = "{$directory}/{$symbol}.json";

                    Storage::disk('local')->put($filename, $json);
                    $riskFactors[] = $symbol;
                }
            }
        }
    }
}