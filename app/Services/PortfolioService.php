<?php

namespace App\Services;

use App\Classes\Output\Percent;
use App\Classes\Output\Price;
use App\Entities\Portfolio;
use App\Facades\Repositories\KeyfigureRepository;
use App\Repositories\CurrencyRepository;
use App\Facades\DataService;


class PortfolioService
{

    /**
     * Return an array of all asset and related fx histories.
     *
     * @param Portfolio $portfolio
     * @param array $attributes
     *
     * @return array
     */
    public function assetHistories(Portfolio $portfolio, $attributes)
    {
        $assetHistory = [];
        foreach ($portfolio->assets as $asset) {

            $assetHistory += $this->assetHistory($asset, $attributes);

            if ($asset->hasForeignCurrency())
                $assetHistory += $this->currencyHistory($asset, array_keys($assetHistory));
        }
        return $assetHistory;
    }


    /**
     * Returns the history of an asset.
     *
     * @param $asset
     * @param $days
     * @return array
     */
    private function assetHistory($asset, $attributes)
    {
        $history = DataService::history($asset->positionable)->weekdays();

        if (array_has($attributes, ['count', 'date'])) {
            $data = $history->count($attributes['count'])->to($attributes['date']);

        } elseif (array_has($attributes, ['from', 'to'])) {
            $data = $history->from($attributes['from'])->to($attributes['to']);

        } else {
            $data = $history;
        }

        return [$asset->label => $data->fill('previous')->getClose()];
    }


    /**
     * Returns the history of the currency pair of an asset.
     *
     * @param $asset
     * @param $days
     * @return null|mixed
     */
    private function currencyHistory($asset, $days)
    {
        $currency = new CurrencyRepository($this->currency->code, $asset->currency->code);
        return [$currency->label() => $currency->history($days)];
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