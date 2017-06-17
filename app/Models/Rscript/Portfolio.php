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

    /**
     * @param int $period number of days scaled by sqrt
     * @param double $conf the VaR confidence level
     *
     * @return array $res with calculated risk results
     */
    public function risk($period, $conf)
    {
        $this->saveAsJson($this->historiesToArray());

        return $this->callRscript(['task' => 'risk', 'conf' => $conf]);

    }
    
    
    public function valueHistory($period)
    {
        $this->saveAsJson($this->historiesToArray());
        
        return $this->callRscript(['task' => 'valueHistory', 'period' => $period]);
    }


    public function summary()
    {
        $this->saveAsJson($this->historiesToArray());

        return $this->callRscript([
            'task' => 'summary',
            'period' => 60,
            'conf' => 0.95
        ]);
    }


    /**
     * Creates an array of positions history data with same dates.
     *
     * @return array
     */
    private function historiesToArray()
    {
        $positions = $this->entity->positions;
        $result = [];

        //Todo: to be based on portfolio settings 1y\6m\2yrs, or similiar
        $dates = array_keys($positions->first()->history(500));

        foreach ($positions as $position) {

            $key = strtoupper($position->positionable_type) . $position->positionable_id;
            $result[$key] = $position->history($dates);

            $origin = $this->entity->currencyCode();
            $target = $position->currencyCode();

            if ($origin != $target)
                $result[$origin.$target] = (new CurrencyRepository($origin, $target))->history($dates);
        }

        return $result;
    }


    /**
     * Saves an array of historic date to the file system.
     *
     * @param array $histories
     * @throws RscriptException
     */
    private function saveAsJson(array $histories)
    {
        foreach ($histories as $key => $history) {
            $filename = $this->path($key.'.json');

            if (!$this->validPriceArray($history))
                throw new RscriptException("'{$filename}' could not be save; incorrect format of input array.");

            Storage::disk('local')->put($filename, json_encode($history, JSON_BIGINT_AS_STRING));
        }
    }


}