<?php

namespace App\Console\Commands\Rscript;

use Illuminate\Console\Command;

class InstallRscript extends Command
{
    protected $shScript;

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
        $this->shScript = storage_path('install/rscript-install.sh');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "Running 'sudo bash {$this->shScript} ...'\n";
        shell_exec($this->shScript);

    }

}
