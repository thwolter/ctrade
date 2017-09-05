<?php

namespace App\Jobs\Metadata;

use App\Repositories\Metadata\BaseMetadata;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RunBulkUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $items;
    protected $base;


    /**
     * Create a new job instance.
     *
     * @param array $items
     * @param BaseMetadata $base
     *
     * @return void
     */
    public function __construct(array $items, BaseMetadata $base)
    {
        $this->items = $items;
        $this->base = $base;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->items as $item) {

            if ($this->base->datasource($item)) {

                if ($this->base->existUpdate($item)) {
                    $this->base->update($item);
                }

            } else {
                $this->base->create($item);
            }

        }
    }
}
