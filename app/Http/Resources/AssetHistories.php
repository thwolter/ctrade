<?php

namespace App\Http\Resources;

use App\Facades\TimeSeries;
use App\Repositories\CurrencyRepository;
use Illuminate\Http\Resources\Json\Resource;

class AssetHistories extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $days = TimeSeries::getWeekDaysSeries($request->all());

        $result = [];
        foreach ($this->assets()->get() as $asset) {

            $result += $this->assetHistory($asset, $days);

            if ($asset->hasForeignCurrency())
                $result += $this->currencyHistory($asset, $days);
        }
        return $result;
    }

    /**
     * Returns the history of an asset.
     *
     * @param $asset
     * @param $days
     * @return array
     */
    private function assetHistory($asset, $days)
    {
        return [$asset->label() => $asset->positionable->history($days)];
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
