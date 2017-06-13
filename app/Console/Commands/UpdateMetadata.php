<?php

namespace App\Console\Commands;

use anlutro\LaravelSettings\Facade as Setting;
use App\Jobs\Metadata\BulkUpdate;
use App\Repositories\Metadata\QuandlSSE;
use Carbon\Carbon;
use Illuminate\Console\Command;


class UpdateMetadata extends Command
{
   
    protected $reposets = [
        ['repo' => QuandlSSE::class, 'chunk' => 50, 'queue' => 'quandl'],
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
            $meta = resolve($set['repo']);

            Setting::set($meta->provider.$meta->database.'updated', Carbon::now());
            Setting::save();

            dispatch(new BulkUpdate($set['repo'], $set['chunk'], $set['queue'], $limit));
        }

        $this->info("Done. \n");
        return;

    }
}