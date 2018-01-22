<?php

namespace App\Jobs\Calculations;


use App\Facades\Repositories\KeyfigureRepository;
use Carbon\Carbon;

class Calculation
{
    protected $object;

    protected $portfolio;


    /**
     * Create a new job instance.
     *
     * @param CalculationObject $object
     */
    public function __construct(CalculationObject $object)
    {
        $this->object = $object;
        $this->portfolio = $this->object->getPortfolio();
    }




    protected function persistContribution($key, $date, $value)
    {
        foreach ($value as $subValue) {
            $proxy = explode('.', key($value));
            $instrument = $proxy[0]::find($proxy[1]);

            $keyfigure = KeyfigureRepository::getComponentVaR($this->object->getPortfolio(), $key, $instrument);
            $keyfigure->effective_at = $this->object->getEffectiveAt();
            $keyfigure->set($date->toDateString(), $subValue);
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
        KeyfigureRepository::getForPortfolio($this->portfolio, $key)
            ->setEffective($this->object->getEffectiveAt())
            ->set($date->toDateString(), $value);
    }
}