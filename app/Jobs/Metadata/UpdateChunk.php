<?php

namespace App\Jobs\Metadata;

use App\Entities\Datasource;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class UpdateQuandlMetadata implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $items;
    protected $repository;



    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($repository, $items)
    {
        $this->items = $items;
        $this->repository = $repository;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $repository = resolve($this->repository);

        foreach ($this->items as $item) {
                
            if ($repository->hasDatasource($item)) 
                $repository->updateItem($item);
                
            else 
                $repository->createItemWithSource($item);
        }
    }
}
