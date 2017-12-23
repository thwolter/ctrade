<?php


namespace App\Services\MetricServices;


use App\Classes\Price;
use App\Entities\Asset;
use App\Facades\DataService;
use App\Facades\Repositories\KeyfigureRepository;

class AssetMetricService extends MetricService
{


    /**
     * Return the Asset's price.
     *
     * @param Asset $asset
     * @param string|null $exchange
     *
     * @return Price
     */
    public function price(Asset $asset, $exchange = null)
    {
        return app()
            ->make('MetricService', [$asset->positionable])
            ->price($asset->positionable, $exchange);
    }


    /**
     * Calculates the Asset's value based on latest available price data.
     *
     * @param Asset $asset
     * @param string|null $exchange
     *
     * @return Price
     */
    public function value(Asset $asset, $exchange = null)
    {
        return $this->price($asset, $exchange)->multiply($asset->amount);
    }


    /**
     * Return the risk for the Asset's confidence level.
     *
     * @param Asset $asset
     * @return Price
     */
    public function risk(Asset $asset)
    {
        $dailyRisk = $this->dailyRisk($asset);

        $value = Price::make(key($dailyRisk), array_first($dailyRisk) * sqrt($this->getPeriod($asset->portfolio)));

        return $value->setCurrency($asset->portfolio->currency->code);
    }


    /**
     * Return the risk to value ratio.
     *
     * @param Asset $asset
     * @return Price
     */
    public function riskToValueRatio(Asset $asset)
    {
        $risk = $this->risk($asset);
        $value = $this->value($asset);

        return Price::make($risk->getDate(), $risk->getValue() / $value->getValue())->setPercent(true);
    }


    /**
     * Return the Asset's risk as latest value stored in the database.
     *
     * @param Asset $asset
     * @return array
     */
    public function dailyRisk(Asset $asset)
    {
        $term = implode('.', ['contribution', $this->getConfidence($asset->portfolio)]);

        return KeyfigureRepository::getComponentVaR($asset->portfolio, $term, $asset->positionable)
            ->timeseries()->count(1)->get();
    }

}
