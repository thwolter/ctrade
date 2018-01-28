<?php

namespace App\Jobs\Calculations;

use App\Entities\Portfolio;
use App\Jobs\Calculations\Traits\PeriodTrait;
use App\Jobs\Calculations\Traits\StatusTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalcPortfolioValue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use PeriodTrait, StatusTrait;

    protected $joblet;

    /**
     * Create a new job instance.
     *
     * @param Portfolio $portfolio
     */
    public function __construct(Portfolio $portfolio)
    {
        $this->joblet = new Joblet($portfolio, 'value');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($dates = $this->dates($this->joblet)) {

            $this->joblet->setTotal($dates->count());
            $this->remember($this->joblet->id, $dates);

            foreach ($dates->chunk(config('calculation.chunk.value')) as $chunk) {
                dispatch(new CalcPortfolioValueChunk($this->joblet, $chunk));
            }
        }
    }
}
