<?php

namespace App\Services;

use App\Classes\Output\Price;
use App\Entities\Asset;
use App\Entities\Portfolio;
use App\Facades\AssetService;
use App\Facades\CurrencyService;
use App\Facades\DataService;
use App\Jobs\Calculations\Traits\StatusTrait;


class PortfolioService
{

    use StatusTrait;


    /**
     * Return the portfolio's account balance (that is, without value of positions).
     *
     * @param Portfolio $portfolio
     * @param string $date
     *
     * @return Price
     */
    public function balance(Portfolio $portfolio, $date = null)
    {
        return new Price($date, (float)$portfolio->balance($date), $portfolio->currency);
    }


    /**
     * Return the value of portfolio's positions (without account balance).
     *
     * @param Portfolio $portfolio
     * @param string $date
     *
     * @return Price
     */
    public function value(Portfolio $portfolio, $date = null)
    {
        $value = 0;

        foreach ($portfolio->assets as $asset) {
            $value += AssetService::convertedValueAt($asset, $date)->value;
        }

        return new Price($date, $value, $portfolio->currency);
    }

    /**
     * Return an array of all asset and related fx histories.
     *
     * @param Portfolio $portfolio
     * @param array $attributes
     *
     * @return array
     */
    public function priceHistory(Portfolio $portfolio, $attributes)
    {
        $attributes = array_merge($attributes, ['weekdays' => true, 'fill' => true]);

        $prices = [];
        foreach ($portfolio->assets as $asset) {

            $prices[$asset->label] = $this->assetHistory($asset, $attributes);

            if ($asset->hasForeignCurrency())
                $prices[$asset->currency->code] = $this->currencyHistory($asset, $attributes);
        }

        return $prices;
    }


    /**
     * Returns the history of an asset.
     *
     * @param Asset $asset
     * @param array $attributes
     * @return array
     */
    private function assetHistory($asset, $attributes)
    {
        return DataService::history($asset->positionable)
            ->attributes($attributes)
            ->getClose();
    }


    /**
     * Returns the history of the currency pair of an asset.
     *
     * @param Asset $asset
     * @param array $attributes
     * @return null|array
     */
    private function currencyHistory($asset, $attributes)
    {
        return CurrencyService::history($asset->currency, $asset->portfolio->currency)
            ->attributes($attributes)
            ->getClose();
    }


    /**
     * Return the Portfolio's absoluteReturn over a specified period.
     *
     * @param Portfolio $portfolio
     * @param int|null $count
     * @return Price
     */
    public function absoluteReturn(Portfolio $portfolio, $count = null)
    {
        $value = 0;

        foreach ($portfolio->assets as $asset) {
            $value += AssetService::convertedYield($asset, $count)->value;
        }

        return new Price(now(), $value, $asset->currency);
    }


    //todo: pull into Portfolio Entity class
    public function nextExecutedAt($portfolio, $date)
    {
        if (!$date) $date = $portfolio->created_at;

        $transaction = collect(array_merge(
            $portfolio->payments()->updatedAfter($date)->get()->all(),
            $portfolio->positions()->updatedAfter($date)->get()->all()
        ))->sortBy('executed_at')->first();

        return optional($transaction)->executed_at;
    }
}