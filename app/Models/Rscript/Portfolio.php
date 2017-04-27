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

        $entity = $this->saveJSON($tmpdir);
        $this->saveSymbols($tmpdir);

        $res = $this->callRscript($tmpdir, [
            'task' => 'risk',
            'entity' => $this->path.$entity,
            'conf' => $conf
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

    /**
     * Saves the portfolio as json file to the file system
     *
     * @return string with name of the json file
     */
    public function saveJSON($directory)
    {
        $filename = "{$directory}/{$this->entityName()}.json";
        Storage::disk('local')->put($filename, json_encode($this->entity->toArray()));

        return $filename;
    }


}