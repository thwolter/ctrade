<?php

namespace App\Services\MetricServices;



use App\Entities\Stock;

class StockMetricService extends MetricService
{

    public function price($stock, $exchange = null)
    {
        return $this->dataService->history($stock, $exchange)->count(1)->getClose();
    }


    public function previousPrice($stock, $exchange = null)
    {
        return array_last(
            $this->dataService->history($stock, $exchange)->count(2)->getClose()
        );
    }


    public function lowPrice($stock, $exchange)
    {
        return $this->dataService->history($stock, $exchange)->count(1)->getLow();
    }


    public function highPrice($stock, $exchange)
    {
        return $this->dataService->history($stock, $exchange)->count(1)->getHigh();
    }


    public function periodHigh($stock, $exchange, $count)
    {
        return max(
            $this->dataService->history($stock, $exchange)->count($count)->getClose()
        );
    }


    public function periodLow($stock, $exchange, $count)
    {
        return min(
            $this->dataService->history($stock, $exchange)->count($count)->getClose()
        );
    }


    public function periodReturn($stock, $exchange, $count)
    {
        $prices = $this->dataService->history($stock, $exchange)->count($count)->getClose();

        return array_first($prices) ? array_first($prices)/array_last($prices) - 1 : null;
    }


    public function dataHistory($stock, $exchange)
    {
        $data = $this->dataService->history($stock, $exchange);

        $datasource = $this->dataService->getDatasource($stock, $exchange);

        return [
            'data' => $data->reverse()->getClose(),
            'currency' => $datasource->currency->code,
            'exchange' => $exchange,
            'datasource_id' => $datasource->id
        ];
    }

    /**
     * Return the entity's price histories for all exchanges.
     *
     * @param $attributes
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


    public function risk($stock, $exchange)
    {
        //
    }
}