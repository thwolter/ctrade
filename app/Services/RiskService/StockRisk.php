<?php

namespace App\Services\RiskService;

use App\Entities\Asset;
use App\Facades\DataService;
use App\Facades\MetricService\StockMetricService;
use Carbon\Carbon;


class StockRisk implements RiskInterface
{
    use RiskHelperTrait;

    /**
     * Return the delta for a stock asset and specified date.
     *
     * @param Asset $asset
     * @param array $parameter
     *
     * @return mixed
     */
    public function delta(Asset $asset, $parameter)
    {
        $date = array_get($parameter, 'date', Carbon::now()->toDateString());

        $price = StockMetricService::priceAtDate($asset->positionable, ['date' => $date]);
        $amount = $asset->amount($date);

        return $price->getValue() * $amount;
    }


    public function VaR(Asset $asset, $parameter)
    {
        $date = array_get($parameter, 'date', Carbon::now()->toDateString());

        $delta = $this->delta($asset, $parameter);
        $history = DataService::history($asset->positionable)
            ->count($parameter['count'])->to($date)->fill('previous')->getClose();

        $volatility = $this->standardDeviation($this->logReturn($history));

        return $this->scaleRisk($delta * $volatility, $parameter);
    }

}