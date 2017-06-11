<?php

namespace App\Console\Commands;

use App\Jobs\UpdateQuandlMetadata;
use App\Repositories\Metadata\QuandlSSE;
use Illuminate\Console\Command;


class UpdateQuandlSSE extends Command
{
    protected $chunkSize = 50;
    protected $repository = QuandlSSE::class;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metaload:quandlSSE
                            {--max= : Maximum pages to be loaded}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates SSE database from Quandl';

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

        $max = $this->option('max');
        if (is_null($max)) $max = INF;

        $meta = resolve($this->repository);
        $i = 0;

        do {
            $i++;
            $items = $meta->getItems($this->chunkSize);

            $job = (new UpdateQuandlMetadata($meta, $items))->onQueue('quandl');
            dispatch($job);

        } while( $items != [] and $i < $max);

        $this->info("Done. \n");
        return;
    }
}