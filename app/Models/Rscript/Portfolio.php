<?php


namespace App\Models\Rscript;


use App\Models\QuantModel;
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

    public function summary()
    {
        $tmpdir = $this->makeDirectory();
        $this->saveSymbols($tmpdir);

        return $this->callRscript($tmpdir,
            ['task' => 'summary', 'period' => 60, 'conf' => 0.95]);
    }
    
    

    public function saveSymbols($directory)
    {
        $saved = [];

        foreach ($this->entity->positions as $position) {
            $id = 'pos-'.$position->id;
            if (! in_array($id, $saved)) {

                $json = $position->history();
                $filename = "{$directory}/{$id}.json";

                Storage::disk('local')->put($filename, $json);
                $saved[] = $id;
            }


            if (! $position->hasCurrency($this->entity->currency())) {
                $symbol = $this->entity->currency->code.$position->currency()->code;
                if (!in_array($symbol, $saved)) {

                    $json = QuantModel::ccyHistory($this->entity->currency->code, $position->currency()->code);
                    $filename = "{$directory}/{$symbol}.json";

                    Storage::disk('local')->put($filename, $json);
                    $saved[] = $symbol;
                }
            }
        }
    }


}