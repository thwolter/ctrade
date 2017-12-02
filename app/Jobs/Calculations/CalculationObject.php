<?php

namespace App\Jobs\Calculations;


use App\Entities\Portfolio;
use App\Events\PortfolioWasCalculated;
use App\Notifications\RiskCalculated;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CalculationObject
{
    protected $portfolio;
    protected $type;

    protected $dates;
    protected $chunk;

    protected $user;
    protected $effective_at;


    public function __construct(Portfolio $portfolio, $type)
    {
        $this->portfolio = $portfolio;
        $this->type = $type;

        $this->init();
    }

    public function __destruct()
    {
        \Cache::forget($this->cacheTag());
    }


    private function init()
    {
        $this->effective_at = Carbon::now();
        Log::info("Check key figure '{$this->type}' on portfolio {$this->portfolio->id} ...");

        $this->dates = $this->datesToCompute();
        $this->user = $this->portfolio->user;

        if ($this->dates) {
            \Cache::forever($this->cacheTag(), $this->dates->count());
            $this->keyFigure()->update(['effective_at' => $this->effective_at]);

            Log::info("Start calculation with date {$this->dates->first()} ...");

        } else {
            Log::info('Nothing to calculate; all values up-to-date.');
        }
    }


    private function cacheTag()
    {
        return 'calculate-' . implode('.', [$this->type, $this->portfolio->id]);
    }


    public function hasDates()
    {
        return count($this->dates) > 0;
    }


    /**
     * @return mixed
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * @param mixed $chunk
     */
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
        \Cache::decrement($this->cacheTag());
        $ratio = \Cache::get($this->cacheTag()) / $this->dates->count();

        $this->user->notify(new RiskCalculated($ratio));

        if ($ratio == 0) {
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
        $keyFigureDate = $this->portfolio->keyFigure($this->type)->effective_at;

        return $keyFigureDate
            ? optional($this->portfolio->firstTransactionEnteredAfter($keyFigureDate))->executed_at
            : $this->portfolio->created_at;
    }

}