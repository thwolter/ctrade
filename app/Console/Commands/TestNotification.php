<?php

namespace App\Console\Commands;

use App\Notifications\StatusCalculation;
use Illuminate\Console\Command;
use App\Mail\MetadataUpdated;

class TestNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
       new StatusCalculation(0.20);
    }
}