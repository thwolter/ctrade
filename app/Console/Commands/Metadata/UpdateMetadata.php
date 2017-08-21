<?php

namespace App\Console\Commands\Metadata;

use App\Jobs\Metadata\UpdateQuandlECB;
use App\Jobs\Metadata\UpdateQuandlFSE;
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

        dispatch((new UpdateQuandlECB())->onQueue('quandl'));

        dispatch((new UpdateQuandlSSE())->onQueue('quandl'));
        dispatch((new UpdateQuandlFSE())->onQueue('quandl'));

        $this->info("Done. \n");
        return;

    }
}