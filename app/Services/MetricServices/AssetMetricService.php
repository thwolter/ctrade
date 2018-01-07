<?php


namespace App\Services\MetricServices;


use App\Classes\Output\Percent;
use App\Classes\Output\Price;
use App\Entities\Asset;
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
        $risk = array_first($dailyRisk) * sqrt($this->getPeriod($asset->portfolio));

        return new Price(key($dailyRisk), $risk, $asset->portfolio->currency->code);
    }


    /**
     * Return the risk to value ratio.
     *
     * @param Asset $asset
     * @return Percent
     */
    public function riskToValueRatio(Asset $asset)
    {
        $risk = $this->risk($asset);
        $value = $this->value($asset);

        return new Percent($risk->getDate(), $risk->getValue() / $value->getValue());
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
