<?php

namespace App\Jobs;

use App\Entities\Portfolio;
use App\Models\Rscript;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CalcPortfolioValue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $portfolio;

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
        $kfValue = $this->portfolio->keyFigure('value');

        $start = $kfValue->calculateFromDate();
        $today = Carbon::now()->endOfDay();

        for ($date = clone $start; $date->diffInDays($today, false) >= 0; $date->addDay()) {

            $portfolio = $this->portfolio->rollbackToDate($date);

            $rscript = new Rscript($portfolio);
            $value = $rscript->portfolioValue($date->toDateString());

            $kfValue->set($date->toDateString(), array_first_or_null($value['value']));
        }

        $kfValue->validUntil($today->startOfDay());
    }
}
