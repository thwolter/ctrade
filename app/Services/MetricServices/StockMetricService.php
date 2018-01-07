<?php

namespace App\Services\MetricServices;

use App\Classes\Price;
use App\Entities\Stock;
use App\Facades\DataService;
use App\Facades\RiskService\RiskService;
use App\Facades\RscriptService\RscriptService;
use Carbon\Carbon;
use MathPHP\Statistics\Circular;
use MathPHP\Statistics\RandomVariable;
use MathPHP\Probability\Distribution\Continuous;


class StockMetricService extends MetricService
{

    public function price($stock, $exchange = null)
    {
        return $this->priceAtDate($stock, ['exchange' => $exchange]);
    }


    public function priceAtDate($stock, $parameter = [])
    {
        $exchange = array_get($parameter, 'exchange');
        $date = array_get($parameter, 'date');

        $value = $this->dataService->history($stock, $exchange)->count(1)->to($date)->getClose();

        return Price::make(key($value), array_first($value))->setCurrency($stock->currency->code);
    }


    public function previousPrice($stock, $exchange = null)
    {
        $value = $this->dataService->history($stock, $exchange)->count(2)->getClose();

        return Price::make(key($value), array_first($value))->setCurrency($stock->currency->code);
    }


    public function lowPrice($stock, $exchange)
    {
        $value = $this->dataService->history($stock, $exchange)->count(1)->getLow();

        return Price::make(key($value), array_first($value))->setCurrency($stock->currency->code);

    }


    public function highPrice($stock, $exchange)
    {
        $value = $this->dataService->history($stock, $exchange)->count(1)->getHigh();

        return Price::make(key($value), array_first($value))->setCurrency($stock->currency->code);
    }


    public function periodHigh($stock, $exchange, $count)
    {
        $value = max($this->dataService->history($stock, $exchange)->count($count)->getClose());

        return Price::make(null, $value)->setCurrency($stock->currency->code);

    }


    public function periodLow($stock, $exchange, $count)
    {
        $value = min($this->dataService->history($stock, $exchange)->count($count)->getClose());

        return Price::make(null, $value)->setCurrency($stock->currency->code);

    }


    public function periodReturn($stock, $exchange, $count)
    {
        $value = $this->dataService->history($stock, $exchange)->count($count)->getClose();

        return Price::make(key($value), array_first($value))->setCurrency($stock->currency->code);
    }


    public function dataHistory($stock, $exchange)
    {
        $data = $this->dataService->history($stock, $exchange);

        $datasource = $this->dataService->getDatasource($stock, $exchange);

        return [
            'data' => $data->getClose(),
            'currency' => $datasource->currency->code,
            'exchange' => $exchange,
            'datasource_id' => $datasource->id
        ];
    }

    /**
     * Return the entity's price histories for all exchanges.
     *
     * @param Stock $stock
     * @param integer $count
     *
     * @return array
     */
    public function historiesByExchange(Stock $stock, $count = null)
    {
        $prices = [];
        foreach ($stock->datasources  as $datasource) {
            $exchange = $datasource->exchange->code;

            $prices[] = [
                'exchange' => $exchange,
                'data' => $this->dataService->history($stock, $exchange)->count($count)->getClose(),
                'datasourceId' => $datasource->id];
        };
        return $prices;
    }


    public function risk($stock)
    {
        $parameter = \Auth::user()->settings()->only(['confidence', 'period', 'history']);
        $parameter = array_replace_key($parameter, 'history', 'count');

        $risk = RiskService::instrumentVaR($stock, $parameter);

        return Price::make(Carbon::now()->toDateString(), $risk)->setCurrency($stock->currency->code);
    }


    public function riskToPrice($stock, $exchange)
    {
        return $this->risk($stock)
            ->multiply(1 / $this->price($stock, $exchange)->getValue())
            ->setPercent(true);
    }


    public function expectedReturn($stock, $exchange)
    {
        $history = \Auth::user()->settings('history');

        $history = DataService::history($stock, $exchange)->count($history)->getClose();
        $expected = Circular::mean($history);

        return Price::make(key($history), $expected)->setCurrency($stock->currency->code);
    }


    public function expectedReturnToPrice($stock, $exchange)
    {
        return $this->expectedReturn($stock, $exchange)
            ->multiply(1 / $this->price($stock, $exchange)->getValue())
            ->setPercent(true);
    }
}