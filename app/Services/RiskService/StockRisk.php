<?php

namespace App\Services\RiskService;

use App\Classes\Output\OutputHelper;
use App\Entities\Asset;
use App\Entities\Currency;
use App\Entities\Stock;
use App\Facades\CurrencyService;
use App\Facades\DataService;
use Carbon\Carbon;


class StockRisk implements RiskInterface
{
    use RiskHelperTrait;
    use OutputHelper;


    public function assetVaR($asset, $parameter)
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
     */
    public function assetDelta($asset, $parameter)
    {
        $date = $this->getDate($parameter);

        return $this->instrumentDelta($asset->positionable, $parameter) * $asset->amountAt($date);
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
     * @param Stock $entity
     * @param array $parameter
     * @return array
     */
    public function instrumentDelta($entity, $parameter)
    {
        return [
            $this->stockDelta($entity, $parameter),
            $this->fxDelta($entity, $parameter),
        ];
    }

    /**
     * @param $entity
     * @param $parameter
     * @return array
     */
    private function stockDelta($entity, $parameter): array
    {
        return [
            'class' => Stock::class,
            'id' => $entity->id,
            'value' => $this->getStockPrice($entity, $parameter)->getValue(),
        ];
    }

    /**
     * @param $entity
     * @param $parameter
     * @return mixed
     */
    private function getStockPrice($entity, $parameter)
    {
        return DataService::priceAt($entity, ['date' => $this->getDate($parameter)]);
    }

    /**
     * @param $entity
     * @param $parameter
     * @return array
     */
    private function fxDelta($entity, $parameter)
    {
        if ($entity->currency === $entity->portfolio->currency) return null;

        return [
            'class' => Currency::class,
            'id' => $entity->currency->id,
            'value' => $this->getFxRate($entity, $parameter)->getValue(),
        ];
    }

    /**
     * @param $entity
     * @param $parameter
     * @return mixed
     */
    private function getFxRate($entity, $parameter)
    {
        $fxRate = CurrencyService::priceAt(
            $entity->currency->code,
            $entity->portfolio->currency->code,
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

    public function instrumentVaR($entity, $parameter)
    {
        $delta = $this->instrumentDelta($entity, $parameter);
        $volatility = $this->stockVolatility($entity, $parameter);

        return $this->scaleRisk($delta * $volatility, $parameter);
    }


}