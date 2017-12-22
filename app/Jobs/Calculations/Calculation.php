<?php

namespace App\Jobs\Calculations;


use App\Facades\KeyfigureRepository;
use Carbon\Carbon;

class Calculation
{
    protected $object;


    /**
     * Create a new job instance.
     *
     * @param CalculationObject $object
     */
    public function __construct(CalculationObject $object)
    {
        $this->object = $object;
    }


    /**
     * Run through the risk.data array and persist the keyfigures.
     *
     * @param Carbon $date
     * @param array $risk
     */
    protected function storeKpis($date, $risk)
    {
        foreach ($risk['data'] as $key => $value) {
            $this->persist($key, $date, $value);
        }
    }


    /**
     * Persist a keyfigures.
     *
     * @param string $key
     * @param Carbon $date
     * @param $value
     */
    protected function persist($key, $date, $value)
    {
        $keyfigure = KeyfigureRepository::getForPortfolio($this->object->getPortfolio(), $key);
        $keyfigure->effective_at = $this->object->getEffectiveAt();
        $keyfigure->set($date->toDateString(), $value);
    }
}