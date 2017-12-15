<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallRscript extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rscript:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install R command line and required R packages.';


  
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
        echo "Please call 'sudo bash ".base_path('rscripts/Install/install.sh')."'\n";
    }
}
