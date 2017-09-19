<?php

namespace App\Jobs\Calculations;

use App\Entities\Portfolio;
use App\Events\PortfolioWasCalculated;
use App\Models\Rscript;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CalcPortfolioValueChunk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $portfolio;

    protected $dates;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Portfolio $portfolio, $dates)
    {
        $this->portfolio = $portfolio;
        $this->dates = $dates;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->dates as $date)
        {
            $key = $date->toDateString();
            $value = $this->calculateValue($date);

            $this->portfolio->keyFigure('value')->set($key, array_first_or_null($value['value']));
        }

        event(new PortfolioWasCalculated($this->portfolio));

    }

    /**
     * @return array
     */
    private function calculateValue($date)
    {
        $rscript = new Rscript($this->portfolio);
        return $rscript->portfolioValue($date->toDateString());
    }
}
