<?php
/**
 * Calculates the information required to decide whether the user should receive information on
 * the portfolios risk based on the portfolio settings e.g. limit, threshold, and email frequency.
 *
 */

namespace App\Jobs;

use App\Entities\Portfolio;
use App\Facades\Helpers;
use App\Facades\Mapping;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use \App\Models\Rscript\Portfolio as Rscript;

class PreparePortfolioMail implements ShouldQueue
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

        $days = Helpers::allWeekDaysBetween($this->portfolio->created_at, Carbon::now());

        $r = new Rscript($this->portfolio);

        //calculate the risk for today and previous period
        //dispatch an email job with a timing as define in portfolio settings


        //$this->portfolio->keyFigures()->whereKey('Risk'.$confidence);
    }
}
