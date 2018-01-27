<?php

namespace App\Jobs\Calculations;


use App\Entities\Portfolio;
use App\Events\PortfolioWasCalculated;
use App\Facades\Repositories\KeyfigureRepository;
use App\Notifications\StatusCalculation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CalculationObject
{
    protected $portfolio;
    protected $term;
    protected $typeRoot;

    protected $dates;
    protected $chunk;
    protected $ratio;

    protected $effective_at;


    public function __construct(Portfolio $portfolio, $term)
    {
        $this->portfolio = $portfolio;
        $this->term = $term;
        $this->typeRoot = explode('.', $term)[0];

        $this->init();
    }

    private function init()
    {
        $this->effective_at = Carbon::now();
        Log::info("Check key figure '{$this->typeRoot}' on portfolio {$this->portfolio->id} ...");

        $this->dates = $this->datesToCompute();

        if ($this->dates) {
            \Cache::forever($this->cacheTagTotal(), $this->dates->count());
            \Cache::forever($this->cacheTagRemainder(), $this->dates->count());

            Log::info("Start calculation with date {$this->dates->first()} ...");

        } else {
            Log::info('Nothing to calculate; all values up-to-date.');
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
        $effective = $this->keyfigure()->effective_at;
        $calculated = $this->keyfigure()->date;
        $executed = optional($this->portfolio->firstTransactionEnteredAfter($effective))->executed_at;

        $dates = array_filter([$effective, $calculated, $executed, $this->portfolio->created_at], function ($v) {
            return !is_null($v);
        });

        $startDate = $dates ? min($dates) : null;

        return $startDate ? $startDate : $this->portfolio->created_at;
    }

    private function keyfigure()
    {
        return KeyfigureRepository::getForPortfolio($this->portfolio, $this->term);
    }

    private function cacheTagTotal()
    {
        return $this->cacheTag('total');
    }

    private function cacheTag($attribute)
    {
        return implode('.', ['calculate', $this->term, $attribute, $this->portfolio->id]);
    }

    private function cacheTagRemainder()
    {
        return $this->cacheTag('remainder');
    }

    static public function getStatus(Portfolio $portfolio, array $terms)
    {
        $result = [];
        foreach ($terms as $term) {
            $result[$term] = [
                'total' => \Cache::get(implode('.', ['calculate', $term, 'total', $portfolio->id])),
                'remainder' => \Cache::get(implode('.', ['calculate', $term, 'remainder', $portfolio->id]))
            ];
        }
        return json_encode($result);
    }

    public function __destruct()
    {
        \Cache::forget($this->cacheTagTotal());
        \Cache::forget($this->cacheTagRemainder());
    }

    public function hasDates()
    {
        return count($this->dates) > 0;
    }

    public function getDates()
    {
        return $this->dates;
    }

    /**
     * @return mixed
     */
    public function getChunk()
    {
        return $this->chunk;
    }

    public function setChunk($chunk)
    {
        $this->chunk = $chunk;
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
        return $this->term;
    }

    public function getUserId()
    {
        return $this->portfolio->user_id;
    }

    public function total()
    {
        return intval(\Cache::get($this->cacheTagTotal()));
    }

    public function notifyCompletion(Carbon $date)
    {
        \Cache::decrement($this->cacheTagRemainder());

        $this->portfolio->user->notify(new StatusCalculation($this));

        if ($this->remainder() === 0) {
            event(new PortfolioWasCalculated($this->portfolio));
            Log::info("Calculation of '{$this->typeRoot}' for portfolio {$this->portfolio->id} finished.");
        }
    }


    /* ---------------------------------------------------
    // Static Function
    // -------------------------------------------------*/

    public function remainder()
    {
        return intval(\Cache::get($this->cacheTagRemainder()));
    }
}