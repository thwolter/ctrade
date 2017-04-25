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
        foreach ($this->entity->symbols() as $symbol)
        {
            if (stripos($symbol, '/') > 0) {
                
                $json = OandaFinancial::history()->get($symbol);
                $filename = $directory.'/'.str_replace('/', '_', $symbol).'.json';
                
            } else {
                
                $json = Financial::history()->get($symbol);
                $filename = "{$directory}/{$symbol}.json";
            }
            
            Storage::disk('local')->put($filename, $json);
        }
    }
}