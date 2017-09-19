<?php

namespace App\Console\Commands\Calculations;

use App\Entities\Portfolio;
use App\Jobs\Calculations\CalcPortfolioValue;
use Illuminate\Console\Command;

class CalculateValue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:value';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate the Values of existing portfolios.';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (Portfolio::all() as $portfolio)
        {
            dispatch(new CalcPortfolioValue($portfolio));
        }
        $this->info("Done. \n");
        return;
    }
}
