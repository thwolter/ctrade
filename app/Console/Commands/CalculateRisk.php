<?php

namespace App\Console\Commands;

use App\Entities\Portfolio;
use App\Jobs\CalcPortfolioRisk;
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
            dispatch(new CalcPortfolioRisk($portfolio));
        }
        $this->info("Done. \n");
        return;
    }
}
