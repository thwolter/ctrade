<?php

namespace App\Services;

use App\Classes\Output\Percent;
use App\Classes\Output\Price;
use App\Entities\Portfolio;
use App\Facades\AssetService;
use App\Facades\CurrencyService;
use App\Facades\DataService;
use App\Facades\Repositories\KeyfigureRepository;
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
            $value += AssetService::valueAt($asset, $date);
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
        $assetHistory = [];
        foreach ($portfolio->assets as $asset) {

            $assetHistory += $this->assetHistory($asset, $attributes);

            if ($asset->hasForeignCurrency())
                $assetHistory += $this->currencyHistory($asset, $attributes);
        }
        return $assetHistory;
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
        $history = DataService::history($asset->positionable)->attributes($attributes);

        return [$asset->label => $history->getClose()];
    }


    /**
     * Returns the history of the currency pair of an asset.
     *
     * @param $asset
     * @param $days
     * @return null|mixed
     */
    private function currencyHistory($asset, $attributes)
    {
        $history = CurrencyService::history($asset->currency, $asset->portfolio->currency);

        return [$asset->currency->code => $history->attributes($attributes)->getClose()];
    }


    public function nextExecutedAt($portfolio, $date)
    {
        if (!$date) $date = $portfolio->created_at;

        $transaction = collect(array_merge(
            $portfolio->payments()->updatedAfter($date)->get()->all(),
            $portfolio->positions()->updatedAfter($date)->get()->all()
        ))->sortBy('executed_at')->first();

        return optional($transaction)->executed_at;
    }

    /**
     * @param Portfolio $portfolio
     * @return array
     */
    public function valueStocks(Portfolio $portfolio)
    {
        $value = 0;
        $date = null;

        foreach ($portfolio->assets as $asset) {
            $assetValue = AssetService::value($asset);
            $value += $assetValue->getValue();

            $date = max($date, $assetValue->getDate());
        }
        return array($value, $date);
    }


    /**
     * Return the Portfolio's profit over a specified period.
     *
     * @param Portfolio $portfolio
     * @param null $count
     * @param bool $percent
     * @return Percent|Price
     */
    public function profit(Portfolio $portfolio, $count = null, $percent = false)
    {
        $values = KeyfigureRepository::getByPortfolio($portfolio, 'value')->timeseries()
            ->count(1 + ($count || $this->getPeriod($portfolio)))->get();

        if (count($values) != $count) return null;

        return $percent
            ? new Percent(key($values), $this->deltaPercent($values))
            : new Price(key($values), $this->deltaAbsolute($values), $portfolio->currency->code);
    }

    private function getPeriod($entity)
    {
        return $entity->settings('period');
    }

    /**
     * Return the percentage delta for an array with two values.
     *
     * @param $values
     * @return float|null
     */
    private function deltaPercent($values)
    {
        return $this->deltaAbsolute($values) / array_first($values);
    }

    /**
     * Return the absolute delta for an array with two values.
     *
     * @param $values
     * @return float|null
     */
    private function deltaAbsolute($values)
    {
        return array_last($values) - array_first($values);
    }


    public function totalOfType(Portfolio $portfolio, $type)
    {
        $sum = 0;
        foreach ($portfolio->assets()->ofType($type)->get() as $asset) {
            $sum += $asset->value();
        }
        return $sum;
    }


}