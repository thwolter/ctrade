<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;


class deleteTemp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'temp:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'delete the storage/app/tmp directory';

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
        Storage::deleteDirectory('tmp');
        Storage::makeDirectory('tmp');
    }
}
