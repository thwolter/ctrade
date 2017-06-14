<?php

namespace App\Console\Commands;

use App\Jobs\Metadata\BulkUpdate;
use Illuminate\Console\Command;


class UpdateMetadata extends Command
{
   
    protected $reposets = [
        ['repo' => \App\Repositories\Metadata\QuandlSSE::class, 'chunk' => 100, 'queue' => 'quandl'],
        //
    ];


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metadata:update
                            {--test : load only one item from each Repository}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates Metadata';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $limit = ($this->option('test')) ? 1 : INF;

        foreach ($this->reposets as $set)
        {
            dispatch(new BulkUpdate($set['repo'], $set['chunk'], $set['queue'], $limit));
        }
        
        $this->info("Done. \n");
        return;

    }
}