<?php

namespace App\Services\RiskService;

use App\Entities\Asset;
use App\Entities\Stock;
use App\Facades\DataService;
use App\Facades\MetricService\StockMetricService;
use Carbon\Carbon;


class StockRisk implements RiskInterface
{
    use RiskHelperTrait;


    public function assetVaR(Asset $asset, $parameter)
    {
        $delta = $this->delta($asset, $parameter);
        $volatility = $this->stockVolatility($asset->positionable, $parameter);

        return $this->scaleRisk($delta * $volatility, $parameter);
    }


    public function instrumentVaR($entity, $parameter)
    {
        $delta = $this->instrumentDelta($entity, $parameter);
        $volatility = $this->stockVolatility($entity, $parameter);

        return $this->scaleRisk($delta * $volatility, $parameter);
    }


    /**
     * Return the delta for a stock asset and specified date.
     *
     * @param Asset $asset
     * @param array $parameter
     *
     * @return mixed
     */
    public function assetDelta(Asset $asset, $parameter)
    {
        $date = array_get($parameter, 'date', Carbon::now()->toDateString());

        return $this->instrumentDelta($asset->positionable, $parameter) * $asset->amount($date);
    }


    public function instrumentDelta($entity, $parameter)
    {
        $date = array_get($parameter, 'date', Carbon::now()->toDateString());

        return StockMetricService::priceAtDate($entity, ['date' => $date])->getValue();
    }


    /**
     * @param Stock $stock
     * @param $parameter
     * @return number
     */
    private function stockVolatility($stock, $parameter)
    {
        $date = array_get($parameter, 'date', Carbon::now()->toDateString());

        $history = DataService::history($stock)
            ->count($parameter['count'])->to($date)->fill('previous')->getClose();

        return $this->standardDeviation($this->logReturn($history));
    }


}