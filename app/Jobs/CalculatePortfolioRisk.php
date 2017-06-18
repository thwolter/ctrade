<?php

namespace App\Jobs;

use App\Entities\Portfolio;
use App\Facades\Mapping;
use App\Settings\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CalculatePortfolioRisk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var Portfolio
     */
    private $portfolio;

    /**
     * Create a new job instance.
     *
     * @param Portfolio $portfolio
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
        $confidence = Mapping::confidence($this->portfolio->settings('levelConfidence'));



        //get all weekdays which are not in keyfigures which is later than portfolio date
        //run through all dates after this date and
        //calculate the risk
        //store the risk in keyfigures


        //$this->portfolio->keyFigures()->whereKey('Risk'.$confidence);
    }
}
