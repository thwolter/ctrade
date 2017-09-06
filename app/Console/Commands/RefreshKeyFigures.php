<?php

namespace App\Console\Commands;

use App\Console\Commands\Calculations\CalculateRisk;
use App\Console\Commands\Calculations\CalculateValue;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Facades\DB;

class RefreshKeyFigures extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:keyfigures {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculates the keyFigures for existing portfolios.';

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
     * @return void
     */
    public function handle()
    {
        if (! $this->confirmToProceed()) {
            return;
        }

        DB::table('keyfigures')->truncate();

        $this->info('Calculate values ...');
        $this->call('calculate:value');

        $this->info('Calculate risks ...');
        $this->call('calculate:risk');
    }
}
