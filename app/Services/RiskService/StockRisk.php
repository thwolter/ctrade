<?php

namespace App\Services\RiskService;

use App\Entities\Asset;
use App\Facades\DataService;
use App\Facades\MetricService\StockMetricService;
use Carbon\Carbon;


class StockRisk implements RiskInterface
{
    use RiskHelperTrait;

    const ASSESSMENT_PERIOD = 250;
    const DEFAULT_CONFIDENCE = 0.95;
    const DEFAULT_PERIOD = 1;

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
        $count = array_get($parameter, 'count', self::ASSESSMENT_PERIOD);
        $confidence = array_get($parameter, 'confidence', self::DEFAULT_CONFIDENCE);
        $period = array_get($parameter, 'period', self::DEFAULT_PERIOD);

        $delta = $this->delta($asset, $parameter);
        $history = DataService::history($asset->positionable)->count($count)->to($date)->fill('previous')->getClose();
        $volatility = $this->standardDeviation($this->logReturn($history));

        return $delta * $volatility * $this->inverseCdf($confidence) * sqrt($period);
    }

}