<?php

namespace App\Services\MetricServices;


use App\Entities\Portfolio;
use App\Services\DataService;

class MetricService
{
    protected $withDate = false;

    protected $entity;

    protected $dataService;



    public function __construct($entity)
    {
        $this->entity = $entity;

        $this->dataService = new DataService();
    }


    public function withDate()
    {
        $this->withDate = true;
        return $this;
    }

    protected function shapeOutput($result)
    {
        if ($this->withDate) {
            $this->withDate = false;
            return $result;

        } else {
            return (count($result) === 1) ? array_values($result)[0] : $result;
        }
    }

    protected function getConfidence(Portfolio $portfolio)
    {
        return trim($portfolio->settings('confidence'), '0.');
    }

    protected function getPeriod(Portfolio $portfolio)
    {
        return $portfolio->settings('period');
    }

    protected function toArray($keyfigure)
    {
        return $keyfigure ? $keyfigure->values : [];
    }
}