<?php

namespace App\Jobs\Calculations;


use App\Facades\Repositories\KeyfigureRepository;
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

            if (substr($key, 0,12) === 'contribution') {
                $this->persistContribution($key, $date, $value);

            } else {
                $this->persist($key, $date, $value);
            }
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


    protected function persistContribution($key, $date, $value)
    {
        foreach ($value as $subValue)
        {
            $proxy = explode('.', key($value));
            $instrument = $proxy[0]::find($proxy[1]);

            $keyfigure = KeyfigureRepository::getComponentVaR($this->object->getPortfolio(), $key, $instrument);
            $keyfigure->effective_at = $this->object->getEffectiveAt();
            $keyfigure->set($date->toDateString(), $subValue);
        }
    }
}