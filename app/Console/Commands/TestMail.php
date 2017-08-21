<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\MetadataUpdated;

class TestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:mail';

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
        \Mail::to(config('mail.admin'))->queue(new MetadataUpdated([
                'provider' => 'Quandl',
                'database' => 'SSE',
                'created' => 100,
                'updated' => 0,
                'invalidated' => 2,
                'validated' => 0,
                'total' => 100,
                'valid' => 100
            ]
        ));    
    }
}
