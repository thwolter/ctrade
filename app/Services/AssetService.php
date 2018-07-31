<?php


namespace App\Services;


use App\Classes\Output\Percent;
use App\Classes\Output\Price;
use App\Entities\Asset;
use App\Exceptions\AssetServiceException;
use App\Facades\CurrencyService;
use App\Facades\DataService;
use Carbon\Carbon;

class AssetService
{

    /**
     * Return the asset's delta as a percentage.
     *
     * @param Asset $asset
     * @param null $date
     *
     * @return float|int
     */
    public function convertedYieldPercent(Asset $asset, $date = null)
    {
        return $this->convertedYield($asset, $date) / $asset->convertedSettlement($date);
    }


    /**
     * Return the asset's delta as a percentage.
     *
     * @param Asset $asset
     * @param null $date
     *
     * @return float|int
     */
    public function yieldPercent(Asset $asset, $date = null)
    {
        return $this->convertedYield($asset, $date) / $asset->settlement($date);
    }


    /**
     * Return the asset's delta as a percentage.
     *
     * @param Asset $asset
     * @param int $count
     *
     * @return float|int
     */
    public function convertedYieldPeriodPercent(Asset $asset, $count = 1)
    {
        return $this->convertedYield($asset, $count) / $asset->convertedSettlement();
    }


    /**
     * Return the asset's delta as a percentage.
     *
     * @param Asset $asset
     * @param int $count
     *
     * @return float|int
     */
    public function yieldPeriodPercent(Asset $asset, $count = 1)
    {
        return $this->convertedYield($asset, $count) / $asset->settlement();
    }


    /**
     * Return the asset's delta between current value and invested amount in portfolio currency.
     *
     * @param Asset $asset
     * @param string $date
     * @return float
     */
    public function convertedYield(Asset $asset, $date = null)
    {
        return $this->convertedValueAt($asset, $date) - $asset->convertedSettlement($date);
    }

    /**
     * Calculates the Asset's value for a specified date.
     *
     * @param Asset $asset
     * @param string $date
     * @param string|null $exchange
     *
     * @return float|int
     */
    public function convertedValueAt(Asset $asset, $date, $exchange = null)
    {
        return $this->valueAt($asset, $date, $exchange) * $this->getFxRate($asset, $date);
    }

    /**
     * Calculates the Asset's value for a specified date.
     *
     * @param Asset $asset
     * @param string $date
     * @param string|null $exchange
     *
     * @return float
     */
    public function valueAt(Asset $asset, $date, $exchange = null)
    {
        return $this->priceAt($asset, $date, $exchange) * $asset->numberAt($date);
    }

    /**
     * @param Asset $asset
     * @param Carbon|string $date
     * @param string|null $exchange
     *
     * @return float
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
            ? CurrencyService::priceAt($asset->currency, $asset->portfolio->currency, $date)
            : 1;
    }

    /**
     * Return the asset's delta between current value and invested amount in portfolio currency.
     *
     * @param Asset $asset
     * @param int $count
     *
     * @return float
     */
    public function convertedYieldPeriod(Asset $asset, $count = 1)
    {
        $compareDate = Carbon::now()->subDays($count)->toDateString();

        return $this->convertedYield($asset) - $this->convertedYield($asset, $compareDate);
    }

    /**
     * Return the asset's delta between current value and invested amount in portfolio currency.
     *
     * @param Asset $asset
     * @param int $count
     *
     * @return float
     */
    public function yieldPeriod(Asset $asset, $count = 1)
    {
        $compareDate = Carbon::now()->subDays($count)->toDateString();

        return $this->yield($asset) - $this->yield($asset, $compareDate);
    }

    /**
     * Return the asset's delta between current value and invested amount in portfolio currency.
     *
     * @param Asset $asset
     * @param string $date
     * @return float
     */
    public function yield(Asset $asset, $date = null)
    {
        return $this->valueAt($asset, $date) - $asset->settlement($date);
    }

    /**
     * Return the Asset's price.
     *
     * @param Asset $asset
     * @param string|null $exchange
     *
     * @return float
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
     * @return float
     */
    public function convertedPriceAt(Asset $asset, $date, $exchange = null)
    {
        return $this->priceAt($asset, $date, $exchange) * $this->getFxRate($asset, $date);
    }

    /**
     * Return the risk to value ratio.
     *
     * @param Asset $asset
     * @return float
     */
    public function riskToValueRatio(Asset $asset)
    {
        return $this->risk($asset) / $value = $this->value($asset);
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
     * @return float
     */
    public function convertedValue(Asset $asset, $exchange = null)
    {
        return $this->valueAt($asset, now(), $exchange) * $this->getFxRate($asset);
    }

}
