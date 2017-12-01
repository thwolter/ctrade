<?php


namespace App\Services;


use App\Entities\Asset;

class AssetMetrics
{

    protected $asset;

    protected $confidence;
    protected $period;


    public function __construct(Asset $asset)
    {
        $this->asset = $asset;
        $this->setParameters();
    }


    private function setParameters()
    {
        $this->confidence = $this->asset->portfolio->settings('confidence');
        $this->period = $this->asset->portfolio->settings('period');
    }



    public function risk()
    {
        return $this->dailyRisk() * sqrt($this->period);
    }


    public function riskRatio()
    {
        return $this->risk() / $this->asset->value();
    }


    public function dailyRisk()
    {
        $keyfigure = $this->asset->portfolio->keyFigure('contribution')->value;
        return head($keyfigure[(string)$this->confidence][$this->asset->label()]);
    }



}