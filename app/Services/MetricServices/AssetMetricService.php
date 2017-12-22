<?php


namespace App\Services\MetricServices;


use App\Classes\Price;
use App\Entities\Asset;

class AssetMetricService extends MetricService
{


    public function price(Asset $asset, $exchange = null)
    {
        $price = app()
            ->make('MetricService', [$asset->positionable])
            ->price($asset->positionable, $exchange);

        return new Price(key($price), array_first($price));
    }


    public function value(Asset $asset, $exchange = null)
    {
        return $this->price($asset, $exchange)->multiply($asset->amount);
    }


    public function risk(Asset $asset)
    {
        return $this->riskDb($asset);
    }


    public function riskDb(Asset $asset, $data = null)
    {
        $dailyRisk = $this->withDate()->dailyRisk($asset);

        return $this->shapeOutput(
            [key($dailyRisk) => array_first($dailyRisk) * sqrt($this->getPeriod($asset->portfolio))]
        );
    }


    public function riskRatio(Asset $asset)
    {

    }


    public function dailyRisk(Asset $asset)
    {
        return $this->shapeOutput(
            array_slice($this->getRisks($asset), -1, 1, true)
        );
    }


    private function getRisks($asset)
    {
        return $this->toArray(
            $asset->portfolio->keyfigure('risk.' . $this->getConfidence($asset->portfolio))
        );
    }
}
