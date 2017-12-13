<?php


namespace App\Services\Metrics;


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


    public function dailyRisk(Asset $asset)
    {
        return $this->shapeOutput(
            array_slice($this->getRisks($asset),-1, 1, true)
        );
    }


    private function getRisks($asset)
    {
        $a=1;
        //$this->asset->label()
        return $asset->portfolio->keyfigures()
            ->ofType('contribution.'.$this->getConfidence($asset->portfolio))->first()->values;
    }
}
