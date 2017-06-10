<?php

namespace App\Jobs;

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
    protected $meta;



    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($meta, $items)
    {
        $this->items = $items;
        $this->meta = $meta;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        foreach ($this->items as $item) {
                
            if ($this->meta->hasDatasource($item)) 
                $this->meta->updateItem($item);
                
            else 
                $this->meta->createItemWithSource($item);
        }
    }
}
