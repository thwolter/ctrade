<?php

namespace App\Jobs\Calculations;

use App\Models\Rscript;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CalcPortfolioValueChunk extends Calculation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->object->getChunk() as $date)
        {
            $this->storeKpis($date, $this->calculateValue($date));
        }
    }

    /**
     * Start R for calculating the portfolio's value.
     *
     * @param Carbon $date
     * @return array
     */
    private function calculateValue($date)
    {
        $rscript = new Rscript($this->object->getPortfolio());
        return $rscript->portfolioValue($date->toDateString());
    }
}
