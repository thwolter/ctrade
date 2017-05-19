<?php


namespace App\Models\Rscript;


use App\Models\QuantModel;
use Illuminate\Support\Facades\Storage;
use Khill\Lavacharts\Lavacharts;



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
        $this->storeHistoryFiles();

        return $this->callRscript($this->fullpath(), ['task' => 'risk', 'conf' => $conf]);

    }
    
    
    public function valueHistory($period)
    {
        $this->storeHistoryFiles();
        
        return $this->callRscript($this->tmpDir,
            ['task' => 'valueHistory', 'period' => $period]);
    }


    public function summary()
    {
        $this->storeHistoryFiles();

        return $this->callRscript($this->tmpDir,
            ['task' => 'summary', 'period' => 60, 'conf' => 0.95]);
    }
    
    

    public function storeHistoryFiles()
    {
        $positions = $this->entity->positions;

        foreach ($positions as $position) {

            $this->storePositionHistory($position);

            $this->storeCurrencyHistory($this->entity->currency(), $position->currency());

        }
    }


    protected function storePositionHistory($position)
    {
        $filename = "{$this->tmpDir}/pos-{$position->id}.json";

        if (! file_exists($filename)) {

            Storage::disk('local')->put($filename, $position->history());
        }
    }


    protected function storeCurrencyHistory(Currency $base, Currency $target)
    {
        $filename = "{$this->tmpDir}/{$base->code}.{$target->code}.json";

        if (! file_exists($filename)) {

            $json = QuantModel::ccyHistory($base->code, $target->code);

            Storage::disk('local')->put($filename, $json);
        }
    }


}