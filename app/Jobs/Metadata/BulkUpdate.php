<?php

namespace App\Jobs\Metadata;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use anlutro\LaravelSettings\Facade as Setting;
use App\Events\MetadataUpdateHasStarted;
use App\Events\MetadataUpdateHasFinished;



class BulkUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
    protected $repo;
    protected $chunk;
    protected $queueName;
    protected $limit;


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

        $repository = resolve($this->repo);
        $chunk = $repository->getItems($this->chunk);

        event(new MetadataUpdateHasStarted($repository->provider, $repository->database));

        while( ($chunk != []) and ($i < $this->limit) )
        {
            $this->updateChunk($repository, $chunk);

            $chunk = $repository->getItems($this->chunk);
            $i++;
        }

        event(new MetadataUpdateHasFinished($repository->provider, $repository->database, [
            'refreshed' => null,
            'created' => null
        ]));
        

    }

    /**
     * @param $chunk
     * @param $repository
     */
    private function updateChunk($repository, $chunk)
    {
        foreach ($chunk as $item) {

            if ($repository->hasDatasource($item))
                $repository->updateItem($item);

            else
                $repository->createItemWithSource($item);
        }
    }
}
