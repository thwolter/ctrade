<?php

namespace App\Services\MetricServices;

use App\Entities\Stock;
use Carbon\Carbon;


class StockMetricService extends MetricService
{

    public function price($exchange = null)
    {
        return $this->dataService->history($this->entity, $exchange)->count(1)->getClose();
    }


    public function previousPrice($exchange = null)
    {
        return array_last(
            $this->dataService->history($this->entity, $exchange)->count(2)->getClose()
        );
    }


    public function lowPrice($exchange)
    {
        return $this->dataService->history($this->entity, $exchange)->count(1)->getLow();
    }


    public function highPrice($exchange)
    {
        return $this->dataService->history($this->entity, $exchange)->count(1)->getHigh();
    }


    public function periodHigh($exchange, $count)
    {
        return max(
            $this->dataService->history($this->entity, $exchange)->count($count)->getClose()
        );
    }


    public function periodLow($exchange, $count)
    {
        return min(
            $this->dataService->history($this->entity, $exchange)->count($count)->getClose()
        );
    }


    public function periodReturn($exchange, $count)
    {
        $prices = $this->dataService->history($this->entity, $exchange)->count($count)->getClose();

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


    public function risk($exchange)
    {
        //
    }
}