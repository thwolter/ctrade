<?php

namespace App\Jobs\Calculations;

use App\Entities\Portfolio;
use App\Events\Limits\LimitHasBreached;
use App\Notifications\LimitBreached;
use App\Repositories\LimitRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckLimits implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
                event(new LimitHasBreached($limit));
            }
        }
    }
}
