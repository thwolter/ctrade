<?php

namespace App\Console\Commands\Metadata;

use Illuminate\Console\Command;


class UpdateMetadata extends Command
{

    private $databases = [
        'ECB',
        'SSE',
        'FSE'
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metadata:update {database?}';

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
        if ($this->argument('database'))
            $this->databases = array_wrap($this->argument('database'));

        foreach ($this->databases as $database)
        {
            dispatch(app('UpdateQuandl', [$database])->onQueue('quandl'));
        }

        $this->info("Done. \n");
        return;

    }
}