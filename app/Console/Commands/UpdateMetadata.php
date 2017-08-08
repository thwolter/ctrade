<?php

namespace App\Console\Commands;

use App\Jobs\Metadata\BulkUpdate;
use App\Jobs\Metadata\UpdateQuandlSSE;
use Illuminate\Console\Command;


class UpdateMetadata extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metadata:update';

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

        dispatch(new UpdateQuandlSSE());

        $this->info("Done. \n");
        return;

    }
}