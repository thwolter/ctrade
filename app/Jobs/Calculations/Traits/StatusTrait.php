<?php

namespace App\Jobs\Calculations\Traits;


use App\Events\PortfolioWasCalculated;
use App\Notifications\StatusCalculation;
use Cache;
use Illuminate\Support\Facades\Log;

trait StatusTrait
{

    protected $tagRemainder = 'remainder';
    protected $tagTotal = 'total';


    protected function remember($id, $dates)
    {
        Cache::forever($this->cacheKey($id, $this->tagTotal), $dates->count());
        Cache::forever($this->cacheKey($id, $this->tagRemainder), $dates->count());

        Log::info(sprintf('Calculating job %s for %s dates', $id, $dates->count()));
    }


    protected function cacheKey($id, $tag)
    {
        return sprintf('%s.%s', $id, $tag);
    }


    protected function updateStatus($joblet, $date)
    {
        Cache::decrement($this->cacheKey($joblet->id, $this->tagRemainder));

        $joblet->portfolio->user->notify(
            new StatusCalculation($joblet, $this->remainder($joblet->id))
        );

        if ($this->remainder($joblet->id) === 0) {
            event(new PortfolioWasCalculated($this->joblet->portfolio));
            Log::info(sprintf('Job %s finished.', $joblet->id));
        }
    }

    public function remainder($id)
    {
        return intval(Cache::get($this->cacheKey($id, $this->tagRemainder)));
    }
}