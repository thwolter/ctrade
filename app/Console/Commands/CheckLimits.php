<?php

namespace App\Console\Commands;

use App\Entities\Portfolio;
use Illuminate\Console\Command;
use App\Jobs\Calculations\CheckLimits As JobCheckLimits;

class CheckLimits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:limits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check limit utilisation of existing portfolios.';

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
            dispatch(new JobCheckLimits($portfolio));
        }

        $this->info(doneInfo($portfolios, 'portfolio'));

        return;
    }
}
