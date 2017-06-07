<?php

namespace App\Console\Commands;

use App\Jobs\UpdateQuandl;
use Illuminate\Console\Command;
use App\Repositories\Metadata\QuandlSSE;

class syncQuandlShares extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quandl:shares';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'syncronize Quandl shares metadata with local database';

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
        $meta = new QuandlSSE($this->output);
        $meta->load();

        $this->info(" Done. \n");
    }
}
