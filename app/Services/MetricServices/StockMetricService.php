<?php

namespace App\Services\MetricServices;



use App\Classes\Price;
use App\Entities\Stock;
use App\Services\RscriptService\RscriptService;
use Carbon\Carbon;


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
            'data' => $data->reverse()->getClose(),
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


    public function risk($stock, $exchange)
    {
        $rscript = new RscriptService($stock->portfolio);

        $value = $rscript->stockRisk($this->price($stock, $exchange)->getDateString(), 250);

        return Price::make(key($value), array_first($value))->setCurrency($stock->currency->code);
    }


    public function expectedReturn($stock, $exchange)
    {
        return Price::make(Carbon::now()->toDateString(), 0)->setCurrency($stock->currency->code);
    }
}