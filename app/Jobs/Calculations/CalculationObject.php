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
    protected $done;
    protected $chunk;

    protected $user;

    public function __construct(Portfolio $portfolio, $type)
    {
        $this->portfolio = $portfolio;
        $this->type = $type;

        $this->init();
    }


    private function init()
    {
        $this->dates = $this->datesToCompute();
        $this->user = $this->portfolio->user;

        \Cache::forever($this->cacheTag(), $this->dates->count());
    }


    private function cacheTag()
    {
        return 'calculate-'.implode([$this->type, $this->portfolio->id]);
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


    public function notifyCompletion(Carbon $date)
    {
        \Cache::decrement($this->cacheTag());
        $ratio = \Cache::get($this->cacheTag()) / $this->dates->count();

        $this->user->notify(new RiskCalculated($ratio));

        if ($ratio == 0) {
            event(new PortfolioWasCalculated($this->portfolio));
        }
    }



    /**
     * @return \Illuminate\Support\Collection
     */
    private function datesToCompute()
    {
        Log::info("Check key figure {$this->type} on portfolio {$this->portfolio->id} ...");
        $startDate = $this->startDate();

        if ($startDate) {
            $interval = new \DateInterval('P1D');
            $period = new \DatePeriod($startDate, $interval, Carbon::now()->endOfDay());

            Log::info("Start calculation with date {$startDate} ...");
            return collect($period);

        } else {
            Log::info('Nothing to calculate; all values up-to-date');
            return null;
        }
    }

    /**
     * @return Carbon
     */
    private function startDate()
    {
        $keyFigureDate = $this->portfolio->keyFigure($this->type)->date;

        return $keyFigureDate
            ? optional($this->portfolio->firstTransactionEnteredAfter($keyFigureDate))->executed_at
            : $this->portfolio->created_at;
    }

}