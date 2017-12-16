<?php


namespace App\Services\MetricServices;


use App\Entities\Asset;

class AssetMetricService extends MetricService
{

    public function risk(Asset $asset)
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
