<?php


namespace App\Services\MetricServices;


use App\Entities\Asset;

class AssetMetricService extends MetricService
{


    public function price(Asset $asset, $exchange = null)
    {
        $metric = app()->make('MetricService', [$asset->positionable]);
        return $metric->price($asset->positionable, $exchange);
    }


    public function value(Asset $asset, $exchange = null)
    {
        return array_map(function($value) use ($asset) {
            return $value * $asset->amount;
        }, $this->price($asset, $exchange));
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
