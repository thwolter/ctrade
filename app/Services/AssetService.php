<?php


namespace App\Services;


use App\Classes\Output\Percent;
use App\Classes\Output\Price;
use App\Entities\Asset;
use App\Facades\CurrencyService;
use App\Facades\DataService;
use Carbon\Carbon;

class AssetService
{


    /**
     * Return the asset's delta as a percentage.
     *
     * @param Asset $asset
     * @return Percent
     */
    public function returnPercent(Asset $asset)
    {
        $delta = $this->returnAbsolute($asset);
        $ratio = $delta->getValue() / $asset->settled();

        return new Percent($delta->getDate(), $ratio);
    }


    /**
     * Return the asset's delta between current value and invested amount.
     *
     * @param Asset $asset
     * @param string $date
     *
     * @return Price
     */
    public function returnAbsolute(Asset $asset, $date = null)
    {
        $date = Carbon::parse($date)->toDateString();

        $delta = $this->value($asset)->getValue() - $asset->settled($date);
        return new Price($this->now(), $delta, $asset->currency->code);
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
        return $this->valueAt($asset, $this->now(), $exchange);
    }

    /**
     * Calculates the Asset's value for a specified date.
     *
     * @param Asset $asset
     * @param string $date
     * @param string|null $exchange
     *
     * @return Price
     */
    public function valueAt(Asset $asset, $date, $exchange = null)
    {
        return $this->priceAt($asset, $date, $exchange)->multiply($asset->amountAt($date));
    }


    /**
     * Return the asset's price at a specified date.
     *
     * @param Asset $asset
     * @param string $date
     * @param string|null $exchange
     *
     * @return Price
     */
    public function priceAt(Asset $asset, $date, $exchange = null)
    {
        $price = DataService::priceAt($asset->positionable, $date, $exchange);
        $fxrate = $this->getFxRate($asset, $date);

        return $price->multiply($fxrate);
    }


    /**
     * @param Asset $asset
     * @param $date
     * @return int
     */
    private function getFxRate(Asset $asset, $date)
    {
        if ($asset->hasForeignCurrency()) {
            $fxrate = CurrencyService::priceAt($asset->currency, $asset->portfolio->currency, $date);
        }

        return isset($fxrate) ? $fxrate->value : 1;
    }


    /**
     * Return the today's date.
     *
     * @return string
     */
    private function now()
    {
        return Carbon::now()->toDateString();
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
     * Return the Asset's price.
     *
     * @param Asset $asset
     * @param string|null $exchange
     *
     * @return Price
     */
    public function price(Asset $asset, $exchange = null)
    {
        return $this->priceAt($asset->positionable, $this->now(), $exchange);
    }

}
