<?php

namespace App\Jobs\Metadata;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
        $chunk = resolve($this->repo)->getItems($this->chunk);

        while( $chunk != [] and $i < $this->limit )
        {
            $job = (new UpdateChunk($this->repo, $chunk))->onQueue($this->queueName);
            dispatch($job);

            $chunk = resolve($this->repo)->getItems($this->chunk);
            $i++;
        }

    }
}
