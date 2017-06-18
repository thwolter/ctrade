<?php


namespace App\Models\Rscript;

use App\Entities\Currency;
use App\Facades\Mapping;
use App\Models\Exceptions\RscriptException;
use App\Models\QuantModel;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Support\Facades\Storage;
use Khill\Lavacharts\Lavacharts;
use App\Repositories\CurrencyRepository;
use When\When;


class Portfolio extends Rscripter
{

    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->setWeekDays(Carbon::now(), $this->entity->settings('historyLength'));
    }

    /**
     * Calculate the risk on portfolio and position level
     *
     * @return array $res with calculated risk results
     */
    public function risk()
    {
        $this->saveAsJson($this->historiesToArray());

        return $this->callRscript([
            'task' => 'risk',
            'conf' => Mapping::confidence($this->entity->settings('levelConfidence'))
        ]);

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
            'period' => Mapping::horizon($this->entity->settings('horizon')),
            'conf' => Mapping::confidence($this->entity->settings('levelConfidence'))
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

        foreach ($positions as $position) {

            $key = strtoupper($position->positionable_type) . $position->positionable_id;
            $result[$key] = $position->history($this->dates);

            $origin = $this->entity->currencyCode();
            $target = $position->currencyCode();

            if ($origin != $target)
                $result[$origin.$target] = (new CurrencyRepository($origin, $target))->history($this->dates);
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

    public function setWeekDays($date, $count = null)
    {
        if (is_null($count)) $count = count($this->dates);

        $dates = array();
        $date = new Carbon($date);

        if ($date->isWeekday())
            $dates[] = $date->format('Y-m-d');

        while (count($dates)<$count)
        {
            $date->subWeekday(1);
            $dates[] = $date->format('Y-m-d');
        }

        return $this->setDates($dates);
    }
}