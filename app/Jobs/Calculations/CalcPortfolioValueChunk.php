<?php

namespace App\Jobs\Calculations;

use App\Entities\Portfolio;
use App\Events\PortfolioWasCalculated;
use App\Models\Rscript;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CalcPortfolioValueChunk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $object;



    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CalculationObject $object)
    {
        $this->object = $object;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->object->getChunk() as $date)
        {
            $key = $date->toDateString();
            $value = $this->calculateValue($date);

            $this->object->set($key, array_first_or_null($value['value']));
        }
    }

    /**
     * @return array
     */
    private function calculateValue($date)
    {
        $rscript = new Rscript($this->object->getPortfolio());
        return $rscript->portfolioValue($date->toDateString());
    }
}
