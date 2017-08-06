<?php

namespace App\Jobs;

use App\Entities\Portfolio;
use App\Notifications\LimitBreached;
use App\Repositories\LimitRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckLimits //implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $portfolio;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $repo = new LimitRepository($this->portfolio);

        foreach ($repo->utilisation() as $key => $value)
        {
            if (array_get($value, 'quota') >= 1) {

                $limit = $repo->get($key);
                $this->portfolio->user->notify(new LimitBreached($limit));
            }
        }
    }
}
