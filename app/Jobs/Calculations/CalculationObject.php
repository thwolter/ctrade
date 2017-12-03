<?php

namespace App\Jobs\Calculations;


use App\Entities\Portfolio;
use App\Events\PortfolioWasCalculated;
use App\Notifications\StatusCalculation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CalculationObject
{
    protected $portfolio;
    protected $type;

    protected $dates;
    protected $chunk;
    protected $ratio;

    protected $effective_at;


    public function __construct(Portfolio $portfolio, $type)
    {
        $this->portfolio = $portfolio;
        $this->type = $type;

        $this->init();
    }

    public function __destruct()
    {
        \Cache::forget($this->cacheTagTotal());
        \Cache::forget($this->cacheTagRemainder());
    }


    private function init()
    {
        $this->effective_at = Carbon::now();
        Log::info("Check key figure '{$this->type}' on portfolio {$this->portfolio->id} ...");

        $this->dates = $this->datesToCompute();

        if ($this->dates) {
            \Cache::forever($this->cacheTagTotal(), $this->dates->count());
            \Cache::forever($this->cacheTagRemainder(), $this->dates->count());

            $this->keyFigure()->update(['effective_at' => $this->effective_at]);

            Log::info("Start calculation with date {$this->dates->first()} ...");

        } else {
            Log::info('Nothing to calculate; all values up-to-date.');
        }
    }


    private function cacheTagRemainder()
    {
        return $this->cacheTag('remainder');
    }


    private function cacheTagTotal()
    {
        return $this->cacheTag('total');
    }


    private function cacheTag($attribute)
    {
        return implode('.', ['calculate', $this->type, $attribute, $this->portfolio->id]);
    }


    public function hasDates()
    {
        return count($this->dates) > 0;
    }


    public function getDates()
    {
        return $this->dates;
    }


    public function setChunk($chunk)
    {
        $this->chunk = $chunk;
    }

    /**
     * @return mixed
     */
    public function getChunk()
    {
        return $this->chunk;
    }


    /**
     * @return Portfolio
     */
    public function getPortfolio()
    {
        return $this->portfolio;
    }

    /**
     * @return mixed
     */
    public function getEffectiveAt()
    {
        return $this->effective_at;
    }

    /**
     * @return mixed
     */
    public function getRatio()
    {
        return $this->ratio;
    }


    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }




    public function total()
    {
        return intval(\Cache::get($this->cacheTagTotal()));
    }


    public function remainder()
    {
        return intval(\Cache::get($this->cacheTagRemainder()));
    }


    private function keyFigure()
    {
        return $this->portfolio->keyFigure($this->type);
    }


    public function set($key, $value)
    {
        $this->keyFigure()->set($key, $value);
    }


    public function notifyCompletion(Carbon $date)
    {
        \Cache::decrement($this->cacheTagRemainder());

        $this->portfolio->user->notify(new StatusCalculation($this));

        if ($this->remainder() === 0) {
            event(new PortfolioWasCalculated($this->portfolio));
            Log::info("Calculation of '{$this->type}' for portfolio {$this->portfolio->id} finished.");
        }
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    private function datesToCompute()
    {
        $startDate = $this->startDate();
        if (!$startDate) return null;

        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($startDate, $interval, Carbon::now()->endOfDay());

        return collect($period);
    }

    /**
     * @return Carbon
     */
    private function startDate()
    {
        $effective = $this->keyFigure()->effective_at;
        $calculated = $this->keyFigure()->date;
        $executed = optional($this->portfolio->firstTransactionEnteredAfter($effective))->executed_at;

        $dates = array_filter([$effective, $calculated, $executed], function ($v) {
            return !is_null($v);
        });

        $startDate = $dates ? min($dates) : null;

        return $startDate ? $startDate : $this->portfolio->created_at;
    }



    /* ---------------------------------------------------
    // Static Function
    // -------------------------------------------------*/


    static public function getStatus(Portfolio $portfolio, array $types)
    {
        $result = [];
        foreach ($types as $type)
        {
            $result[$type] = [
                'total' => \Cache::get(implode('.', ['calculate', $type, 'total', $portfolio->id])),
                'remainder' => \Cache::get(implode('.', ['calculate', $type, 'remainder', $portfolio->id]))
            ];
        }
        return json_encode($result);
    }
}