<?php

namespace App\Console\Commands;

use App\Entities\Keyfigure;
use App\Entities\KeyfigureType;
use App\Entities\Portfolio;
use App\Models\Rscript;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CalculateRisk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:risk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate the Risk for existing portfolios.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $portfolios = Portfolio::all();
        foreach ($portfolios as $portfolio)
        {
            $keyFigure = $portfolio->getKeyFigure('risk');

            if (is_null($keyFigure))
                $keyFigure = $portfolio->createKeyFigure(['code' => 'risk', 'name' => 'Value at Risk']);

            $start = max(max(array_keys($keyFigure->values)), $portfolio->created_at)->endOfDay();
            $today = Carbon::now()->endOfDay();

            for ($date = clone $start; $date->diffInDays($today)>0; $date->addDay())
            {
                if (!$keyFigure->has($date->toDateString())) {

                    $from = (clone $date)->subYear()->toDateString();
                    $to = $date->toDateString();

                    $rscript = new Rscript($portfolio);
                    $risk = $rscript->portfolioRisk(0.95, $from, $to);
dd($risk);
                    $keyFigure->set($risk['date']);
                }
            }
        }
    }
}
