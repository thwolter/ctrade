<?php

namespace App\Jobs\Metadata;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Events\MetadataUpdateHasStarted;
use App\Events\MetadataUpdateHasFinished;
use Carbon\Carbon;
use App\Entities\Datasource;



class BulkUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
    protected $repo;
    protected $chunk;
    protected $queueName;
    protected $limit;
    
    protected $updated;
    protected $created;
    protected $invalidated;

    protected $repository;
    protected $started_at;


    /**
     * Create a new job instance.
     *
     * @param string $repo
     * @param int $chunk
     * @param string $queue
     * @param int $limit
     * 
     * @return void
     */
    public function __construct($repo, $chunk, $queue, $limit)
    {
        $this->repo = $repo;
        $this->chunk = $chunk;
        $this->queueName = $queue;
        $this->limit = $limit;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $i = 0;

        $this->repository = resolve($this->repo);
        $chunk = $this->repository->getItems($this->chunk);

        $this->initCounters();
        $this->starting();

        while( ($chunk != []) and ($i < $this->limit) )
        {
            $this->updateChunk($chunk);

            $chunk = $this->repository->getItems($this->chunk);
            $i++;
        }

        $this->invalidated = $this->invalidated + Datasource::where('updated_at','<', $this->started_at)->update(['valid' => false]);

        event(new MetadataUpdateHasFinished($this->repository->provider, $this->repository->database, $this->countersToArray()));
        
    }

    /**
     * @param $chunk
     */
    private function updateChunk($chunk)
    {
        foreach ($chunk as $item) {

            if ($this->repository->hasDatasource($item)) {
                
                if ($this->repository->updateItem($item))
                    $this->updated++;
                else
                    $this->invalidated++;
            }
            else {
                
                if ($this->repository->createItemWithSource($item))
                    $this->created++;
            }
        }
    }

    /**
     * set counter to zero
     */
    private function initCounters()
    {
        $this->updated = 0;
        $this->created = 0;
        $this->invalidated = 0;
    }

    /**
     * get an key'd array of the counters
     *
     * @return array
     */
    private function countersToArray()
    {
        return [
            'updated' => $this->updated,
            'created' => $this->created,
            'invalidated' => $this->invalidated
        ];
    }

    /**
     * set start timestamp and fire an event
     */
    private function starting()
    {
        $this->started_at = Carbon::now();
        event(new MetadataUpdateHasStarted($this->repository->provider, $this->repository->database));
    }
}
