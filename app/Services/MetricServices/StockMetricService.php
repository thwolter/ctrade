<?php

namespace App\Services\MetricServices;



use App\Classes\Price;
use App\Entities\Stock;
use App\Facades\DataService;
use App\Facades\RscriptService\RscriptService;
use Carbon\Carbon;
use MathPHP\Statistics\Circular;


class StockMetricService extends MetricService
{

    public function price($stock, $exchange = null)
    {
        $value = $this->dataService->history($stock, $exchange)->count(1)->getClose();

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

    // Todo: get parameters from user settings

    public function risk($stock, $exchange)
    {
        $history = DataService::history($stock, $exchange)->count(250)->getClose();

        $sd = Circular::standardDeviation($history);
        $risk = $sd * 1.95 * sqrt(20);

        return Price::make(key($history), $risk)->setCurrency($stock->currency->code);
    }

    // Todo: get parameters from user settings

    public function expectedReturn($stock, $exchange)
    {
        $history = DataService::history($stock, $exchange)->count(250)->getClose();

        $mean = Circular::mean($history);
        $expected = $mean;

        return Price::make(key($history), $expected)->setCurrency($stock->currency->code);
    }
}