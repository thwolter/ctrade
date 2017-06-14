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
        
        $this->updated = 0;
        $this->created = 0;
        $this->invalidated = 0;

        $repository = resolve($this->repo);
        $chunk = $repository->getItems($this->chunk);

        $started_at = Carbon::now();
        event(new MetadataUpdateHasStarted($repository->provider, $repository->database));

        while( ($chunk != []) and ($i < $this->limit) )
        {
            $this->updateChunk($repository, $chunk);

            $chunk = $repository->getItems($this->chunk);
            $i++;
        }

        $this->invalidated = $this->invalidated + Datasource::where('updated_at','<', $started_at)->update(['valid' => false]);
        
        event(new MetadataUpdateHasFinished($repository->provider, $repository->database, [
            'updated' => $this->updated,
            'created' => $this->created,
            'invalidated' => $this->invalidated
        ]));
        
    }

    /**
     * @param $repository
     * @param $chunk
     */
    private function updateChunk($repository, $chunk)
    {
        foreach ($chunk as $item) {

            if ($repository->hasDatasource($item)) {
                
                if ($repository->updateItem($item)) 
                    $this->updated++;
                else
                    $this->invalidated++;
            }
            else {
                
                if ($repository->createItemWithSource($item))
                    $this->created++;
            }
        }
    }
}
