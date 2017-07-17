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

class CalcPortfolioRisk implements ShouldQueue
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
        $keyFigure = $this->portfolio->getKeyFigure('risk');

        if (is_null($keyFigure)) {
            $keyFigure = $this->portfolio->createKeyFigure('risk', 'Value at Risk');
        }

        $start = $this->startDate($keyFigure);
        $today = Carbon::now()->endOfDay();

        for ($date = clone $start; $date->diffInDays($today) > 0; $date->addDay()) {
            if (!$keyFigure->has($date->toDateString())) {

                $rscript = new Rscript($this->portfolio);
                $risk = $rscript->portfolioRisk(0.95, $date->toDateString(), 250);

                $keyFigure->set(array_first($risk['date']), array_first($risk['total']));
            }
        }
    }

    /**
     * Return the start date for calculations as the latest date of already calculated values.
     *
     * @param $keyFigure
     * @return Carbon
     */
    private function startDate($keyFigure)
    {
        $date = $this->portfolio->created_at->endOfDay();

        if (count($keyFigure->values) != 0) {
            $updated = max(max(array_keys($keyFigure->values)), $date);
            $date = Carbon::parse($updated)->addDay()->endOfDay();
        }
        return $date;
    }

}
