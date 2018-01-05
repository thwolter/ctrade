<?php

namespace App\Services;

use App\Entities\Portfolio;
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

        return [$asset->label() => $data->fill('previous')->getClose()];
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

}