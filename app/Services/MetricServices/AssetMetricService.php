<?php


namespace App\Services\MetricServices;


use App\Classes\Price;
use App\Entities\Asset;
use App\Facades\DataService;
use App\Facades\Repositories\KeyfigureRepository;

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
        $a = $this->dailyRisk($asset);
    }

    public function dailyRisk(Asset $asset)
    {
        //
    }

}
