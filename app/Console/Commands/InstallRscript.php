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


    protected $packages = [
        'R6',
        'httr',
        'xts',
        'quantmod',
        'PerformanceAnalytics',
        'jsonlite'
    ];


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
        shell_exec(base_path('rscripts/Install/install.sh'));

        $packagesString = $this->packageString();
        shell_exec("sudo -i R 'install.packages({$this->packageString()})");

        return;
    }

    /**
     * @return string
     */
    private function packageString()
    {
        return "c('" . implode("','", $this->packages) . "')";
    }
}
