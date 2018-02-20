<?php

namespace App\Jobs\Calculations\CalculateChunks;

use App\Facades\AssetService;
use App\Jobs\Calculations\Joblet;
use App\Jobs\Calculations\Traits\PersistTrait;
use App\Jobs\Calculations\Traits\StatusTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PortfolioValueChunk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use PersistTrait, StatusTrait;


    private $joblet;
    private $chunk;


    public function __construct(Joblet $joblet, $chunk)
    {
        $this->joblet = $joblet;
        $this->chunk = $chunk;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->chunk as $date) {

            $this->obtainAssetsValue($date);
            $this->updateStatus($this->joblet, $date);
        }
    }

    /**
     * @param $date
     */
    private function obtainAssetsValue($date)
    {
        $this->persist($this->joblet, $date,
            AssetService::valueAt($this->joblet->portfolio, $date)->value
        );
    }


}
