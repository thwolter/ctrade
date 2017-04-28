<?php


namespace App\Models\Rscript;


use Illuminate\Support\Facades\Storage;
use Khill\Lavacharts\Lavacharts;
use App\Repositories\Yahoo\Financial;
use App\Repositories\OandaFinancial;



class Portfolio extends Rscripter
{


    /**
     * @param int $period number of days scaled by sqrt
     * @param double $conf the VaR confidence level
     *
     * @return array $res with calculated risk results
     */
    public function risk($period, $conf)
    {
        $tmpdir = $this->makeDirectory();
        $this->saveSymbols($tmpdir);

        return $this->callRscript($tmpdir, ['task' => 'risk', 'conf' => $conf]);

    }
    
    
    public function valueHistory($period)
    {
        $tmpdir = $this->makeDirectory();
        $this->saveSymbols($tmpdir);
        
        return $this->callRscript($tmpdir, 
            ['task' => 'valueHistory', 'period' => $period]);
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
                $symbol = $this->entity->currency().$position->currency();
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