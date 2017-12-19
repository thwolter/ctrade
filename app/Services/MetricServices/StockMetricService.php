<?php

namespace App\Services\MetricServices;



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


    public function dataHistory($entity, $exchange)
    {
        $data = $this->history($entity, $exchange)->get();

        $datasource = $this->entity->datasource;

        return [
            'data' => array_values($data->getData()),
            'columns' => $data->getColumns(),
            'currency' => $datasource->currency->code,
            'exchange' => $datasource->exchange->code,
            'datasource_id' => $datasource->id
        ];
    }


    public function risk($stock, $exchange)
    {
        //
    }
}