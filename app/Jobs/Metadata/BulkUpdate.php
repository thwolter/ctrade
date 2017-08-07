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
use App\Facades\Datasource;
use Illuminate\Support\Facades\Log;



class BulkUpdate //implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
    protected $repo;
    protected $chunk;
    protected $queueName;
    protected $limit;
    
    protected $updated;
    protected $created;
    protected $invalidated;
    protected $validated;

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
        $items = $this->repository->getFirstItems($this->chunk);

        if (!$this->someAreFresh($items)) return;

        $this->initCounters();
        $this->starting();

        while( ($items != []) and ($i < $this->limit) )
        {
            $this->updateChunk($items);

            $items = $this->repository->getNextItems($this->chunk);
            $i++;
        }

        $this->invalidated += Datasource::whereProviderAndDatabase(
            $this->repository->provider, $this->repository->database)
            ->where('updated_at','<', $this->started_at)
            ->whereValid(true)
            ->update(['valid' => false]);

        event(new MetadataUpdateHasFinished($this->repository->provider, $this->repository->database, $this->countersToArray()));
    }

    //todo: check that the function delivers true only if realy updates are there.
    private function someAreFresh($items)
    {
        if (is_null($items)) {
            Log::warning('Unable to load data from Quandl.');
            return false;
        }

        foreach ($items as $item) {

            $refreshed_at = $this->repository->refreshed($item);
            $stored = (new Datasource)->get(
                $this->repository->provider,
                $this->repository->database,
                $this->repository->symbol($item));


            if (Datasource::where('updated_at', '>', $refreshed_at)->count() != 0)
                return true;
        }

        return false;
    }

    /**
     * @param $chunk
     */
    private function updateChunk($items)
    {
        foreach ($items as $item) {

            if ($this->repository->hasDatasource($item)) {
                
                $updated = $this->repository->updateItem($item);
                    
                if ($updated == 'invalidated'):
                    $this->invalidated++;
                
                elseif ($updated == 'updated'):
                    $this->updated++;

                elseif ($updated == 'validated'):
                    $this->validated++;
                endif; 
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
        $this->validated = 0;
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
            'invalidated' => $this->invalidated,
            'validated' => $this->validated
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
