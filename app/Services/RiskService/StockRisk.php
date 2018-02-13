<?php

namespace App\Services\RiskService;

use App\Classes\Output\OutputHelper;
use App\Entities\Asset;
use App\Entities\Currency;
use App\Entities\Stock;
use App\Exceptions\RiskServiceException;
use App\Facades\CurrencyService;
use App\Facades\DataService;
use Carbon\Carbon;


class StockRisk implements RiskInterface
{
    use RiskHelperTrait;
    use OutputHelper;


    public function assetVaR(Asset $asset, $parameter)
    {
        $delta = $this->assetDelta($asset, $parameter);
        $volatility = $this->stockVolatility($asset->positionable, $parameter);

        return $this->asPrice($asset, $parameter)->scaleRisk($delta * $volatility, $parameter);
    }

    /**
     * Return the delta for a stock asset and specified date.
     *
     * @param Asset $asset
     * @param array $parameter
     *
     * @return mixed
     * @throws \Throwable
     */
    public function assetDelta(Asset $asset, $parameter)
    {
        $date = $this->getDate($parameter);

        return $this->instrumentDelta($asset->positionable, $parameter) * $asset->numberAt($date);
    }

    /**
     * @param $parameter
     * @return mixed
     */
    private function getDate($parameter)
    {
        return array_get($parameter, 'date', Carbon::now()->toDateString());
    }

    /**
     * @param Asset $asset
     * @param array $parameter
     * @return array
     * @throws \Throwable
     */
    public function instrumentDelta(Asset $asset, $parameter)
    {
        $delta[] = $this->stockDelta($asset, $parameter);

        if ($fxDelta = $this->fxDelta($asset, $parameter)) {
            $delta [] = $fxDelta;
        }

        return $delta;
    }

    /**
     * @param $asset
     * @param $parameter
     * @return array
     */
    private function stockDelta($asset, $parameter): array
    {
        $value = $this->hasForeignCurrency($asset)
            ? $this->getFxRate($asset->positionable, $parameter)->getValue()
            : 1;

        return [
            'class' => Stock::class,
            'id' => $asset->positionable->id,
            'value' => $value
        ];
    }

    /**
     * @param Stock $stock
     * @param $parameter
     * @return mixed
     */
    private function getStockPrice($stock, $parameter)
    {
        return DataService::priceAt($stock, ['date' => $this->getDate($parameter)]);
    }

    /**
     * @param Asset $asset
     * @param array $parameter
     * @return array
     * @throws \Throwable
     */
    private function fxDelta($asset, $parameter)
    {
        if (!$this->hasForeignCurrency($asset)) return null;

        return [
            'class' => Currency::class,
            'id' => $asset->positionable->currency->id,
            'value' => $this->getStockPrice($asset->positionable, $parameter)->getValue()
        ];
    }

    /**
     * @param Asset $asset
     * @return bool
     */
    private function hasForeignCurrency($asset)
    {
        return $asset->positionable->currency === $asset->portfolio->currency;
    }

    /**
     * @param Asset $asset
     * @param $parameter
     * @return mixed
     */
    private function getFxRate($asset, $parameter)
    {
        $fxRate = CurrencyService::priceAt(
            $asset->positionable->currency->code,
            $asset->portfolio->currency->code,
            ['date' => $this->getDate($parameter)]
        );
        return $fxRate;
    }

    /**
     * @param Stock $stock
     * @param $parameter
     * @return number
     */
    private function stockVolatility($stock, $parameter)
    {
        $date = $this->getDate($parameter);

        $history = DataService::history($stock)
            ->count($parameter['count'])->to($date)->fill('previous')->getClose();

        return $this->standardDeviation($this->logReturn($history));
    }


    public function instrumentVaR(Asset $asset, $parameter)
    {
        $delta = $this->instrumentDelta($asset, $parameter);
        $volatility = $this->stockVolatility($asset->positionable, $parameter);

        return $this->scaleRisk($delta * $volatility, $parameter);
    }
}