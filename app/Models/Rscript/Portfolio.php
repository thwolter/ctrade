<?php


namespace App\Models\Rscript;


use App\Entities\Currency;
use App\Models\Exceptions\RscriptException;
use App\Models\QuantModel;
use Illuminate\Support\Facades\Storage;
use Khill\Lavacharts\Lavacharts;
use App\Repositories\CurrencyRepository;



class Portfolio extends Rscripter
{

    public function makeHistoryArray()
    {
        $positions = $this->entity->positions;
        $result = [];
        
        //Todo: this must be done better
        $dates = array_keys($positions[0]);

        foreach ($positions as $position) {
            
            $key = strtoupper($position->positionable_type) . $position->positionable_id;
            $result[$key] = $position->history($dates);
            
            $origin = $this->entity->currencyCode();
            $target = $position->currencyCode();

            if ($origin != $target)
                $result[$origin.$target] = (new CurrencyRepository($origin, $base))->history($dates);
        }
        
        return $result;
    }

    /**
     * @param int $period number of days scaled by sqrt
     * @param double $conf the VaR confidence level
     *
     * @return array $res with calculated risk results
     */
    public function risk($period, $conf)
    {
        $this->storeHistoryFiles();

        return $this->callRscript(['task' => 'risk', 'conf' => $conf]);

    }
    
    
    public function valueHistory($period)
    {
        $this->storeHistoryFiles();
        
        return $this->callRscript(['task' => 'valueHistory', 'period' => $period]);
    }


    public function summary()
    {
        $this->storeHistoryFiles();

        return $this->callRscript(['task' => 'summary', 'period' => 60, 'conf' => 0.95]);
    }
    
    

    public function storeHistoryFiles()
    {
        $positions = $this->entity->positions;

        foreach ($positions as $position) {

            $this->storePositionHistory($position);

            $entityCcy = $this->entity->currencyCode();
            $positionCcy = $position->currencyCode();

            if ($entityCcy != $positionCcy)
                $this->storeCurrencyHistory($entityCcy, $positionCcy);
        }
    }


    protected function storePositionHistory($position)
    {
        $type = strtoupper($position->positionable_type);
        $id = $position->positionable_id;
        $filename = $this->path("{$type}.{$id}.json");

        if (! file_exists($filename)) {

            $history = $position->history();

            if (!$this->validPriceArray($history))
                throw new RscriptException("'{$filename}' could not be save; incorrect format of input array.");

            Storage::disk('local')->put($filename, json_encode($history, JSON_BIGINT_AS_STRING));
        }
    }


    protected function storeCurrencyHistory($origin, $target)
    {
        $filename = $this->path("{$origin}{$target}.json");

        if (! file_exists($filename)) {

            $history = (new CurrencyRepository($origin, $base))->history();
           
            if (!$this->validPriceArray($history))
                throw new RscriptException("File '{$filename}' could not be saved; incorrect format of data array.");

            Storage::disk('local')->put($filename, json_encode($history));
        }
    }


}