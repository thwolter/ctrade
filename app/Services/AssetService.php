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
    public function convertedYieldPercent(Asset $asset, $date = null)
    {
        $yieldRatio = $this->convertedYield($asset, $date)->value / $asset->convertedSettlement($date);

        return new Percent($date, $yieldRatio);
    }


    /**
     * Return the asset's delta as a percentage.
     *
     * @param Asset $asset
     * @return Percent
     */
    public function yieldPercent(Asset $asset, $date = null)
    {
        $yieldRatio = $this->convertedYield($asset, $date)->value / $asset->settlement($date);

        return new Percent($date, $yieldRatio);
    }


    /**
     * Return the asset's delta as a percentage.
     *
     * @param Asset $asset
     * @return Percent
     */
    public function convertedYieldPeriodPercent(Asset $asset, $count = 1)
    {
        $yieldRatio = $this->convertedYield($asset, $count)->value / $asset->convertedSettlement();

        return new Percent(now(), $yieldRatio);
    }


    /**
     * Return the asset's delta as a percentage.
     *
     * @param Asset $asset
     * @return Percent
     */
    public function yieldPeriodPercent(Asset $asset, $count = 1)
    {
        $yieldRatio = $this->convertedYield($asset, $count)->value / $asset->settlement();

        return new Percent(now(), $yieldRatio);
    }


    /**
     * Return the asset's delta between current value and invested amount in portfolio currency.
     *
     * @param Asset $asset
     * @param string $date
     * @return Price
     */
    public function convertedYield(Asset $asset, $date = null)
    {
        $yield = $this->convertedValueAt($asset, $date)->value
            - $asset->convertedSettlement($date);

        return new Price($date, $yield, $asset->portfolio->currency);
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
    public function convertedValueAt(Asset $asset, $date, $exchange = null)
    {
        return $this->valueAt($asset, $date, $exchange)->multiply($this->getFxRate($asset, $date));
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
        return $this->priceAt($asset, $date, $exchange)->multiply($asset->numberAt($date));
    }

    /**
     * @param Asset $asset
     * @param Carbon|string $date
     * @param string|null $exchange
     * @return \App\Services\Price
     */
    public function priceAt(Asset $asset, $date, $exchange = null)
    {
        return DataService::priceAt($asset->positionable, $date, $exchange);
    }

    /**
     * @param Asset $asset
     * @param $date
     * @return int
     */
    private function getFxRate(Asset $asset, $date = null)
    {
        return $asset->hasForeignCurrency()
            ? CurrencyService::priceAt($asset->currency, $asset->portfolio->currency, $date)->value
            : 1;
    }

    /**
     * Return the asset's delta between current value and invested amount in portfolio currency.
     *
     * @param Asset $asset
     * @param int $count
     *
     * @return Price
     */
    public function convertedYieldPeriod(Asset $asset, $count = 1)
    {
        $compareDate = Carbon::now()->subDays($count)->toDateString();

        $yield = $this->convertedYield($asset)->value
            - $this->convertedYield($asset, $compareDate)->value;

        return new Price(now(), $yield, $asset->currency);
    }

    /**
     * Return the asset's delta between current value and invested amount in portfolio currency.
     *
     * @param Asset $asset
     * @param int $count
     *
     * @return Price
     */
    public function yieldPeriod(Asset $asset, $count = 1)
    {
        $compareDate = Carbon::now()->subDays($count)->toDateString();

        $yield = $this->yield($asset)->value
            - $this->yield($asset, $compareDate)->value;

        return new Price(now(), $yield, $asset->currency);
    }

    /**
     * Return the asset's delta between current value and invested amount in portfolio currency.
     *
     * @param Asset $asset
     * @param string $date
     * @return Price
     */
    public function yield(Asset $asset, $date = null)
    {
        $yield = $this->valueAt($asset, $date)->value
            - $asset->settlement($date);

        return new Price($date, $yield, $asset->currency);
    }

    /**
     * Return the Asset's price.
     *
     * @param Asset $asset
     * @param string|null $exchange
     *
     * @return Price
     */
    public function convertedPrice(Asset $asset, $exchange = null)
    {
        return $this->convertedPriceAt($asset->positionable, now(), $exchange);
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
    public function convertedPriceAt(Asset $asset, $date, $exchange = null)
    {
        return $this
            ->priceAt($asset, $date, $exchange)
            ->multiply($this->getFxRate($asset, $date));
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

        return new Percent($risk->date, $risk->value / $value->value);
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
        return $this->valueAt($asset, now(), $exchange);
    }

    /**
     * Calculates the Asset's value for a specified date.
     *
     * @param Asset $asset
     * @param string|null $exchange
     *
     * @return Price
     */
    public function convertedValue(Asset $asset, $exchange = null)
    {
        return $this->valueAt($asset, now(), $exchange)->multiply($this->getFxRate($asset));
    }

}
