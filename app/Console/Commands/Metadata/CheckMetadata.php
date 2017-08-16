<?php

namespace App\Console\Commands\Metadata;

use App\Jobs\Metadata\BulkUpdate;
use App\Jobs\Metadata\UpdateQuandlFSE;
use App\Jobs\Metadata\UpdateQuandlSSE;
use Illuminate\Console\Command;


class CheckMetadata extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metadata:check {symbol} {database} {provider=Quandl}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check a metadata symbol';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $repo = resolve($this->argument('provider').'/'.$this->argument('database'));

        $item = $repo->getSymbol($this->argument('symbol'));

        dd($item);
        return;

    }
}