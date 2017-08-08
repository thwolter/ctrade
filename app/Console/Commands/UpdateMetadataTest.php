<?php

namespace App\Console\Commands;

use App\Jobs\Metadata\BulkUpdate;
use App\Jobs\Metadata\UpdateQuandlSSE;
use Illuminate\Console\Command;


class UpdateMetadataTest extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metadata:test
                            {--test : load only one item from each Repository}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Updates Metadata';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        dispatch(new UpdateQuandlSSE());

        $this->info("Done. \n");
        return;

    }
}