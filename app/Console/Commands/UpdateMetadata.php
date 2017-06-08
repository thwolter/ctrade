<?php

namespace App\Console\Commands;

use App\Jobs\UpdateQuandlMetadata;
use Illuminate\Console\Command;
use App\Repositories\Metadata\QuandlSSE;

class UpdateMetadata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metadata:update
                            {--provider= : Name of the provider (Quandl)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the metadata from data provider';

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
        $provider = $this->option('provider');

        if (!in_array($provider, ['Quandl', null])) {
            $this->comment("Provider {$provider} not defined.");
            return;
        }

        if ($provider == 'Quandl' or $provider == null)
        {
            dispatch(new UpdateQuandlMetadata());
        }

        $this->info("Done. \n");
        return;
    }
}
