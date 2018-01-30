<?php

namespace App\Services;

use App\Classes\Output\Percent;
use App\Classes\Output\Price;
use App\Entities\Stock;
use App\Facades\DataService;
use App\Facades\RiskService\RiskService;
use App\Facades\Repositories\DatasourceRepository;
use Carbon\Carbon;
use MathPHP\Statistics\Circular;


class StockService
{

    public function price($stock, $exchange = null)
    {
        return $this->priceAtDate($stock, ['exchange' => $exchange]);
    }


    public function priceAtDate($stock, $parameter = [])
    {
        $exchange = array_get($parameter, 'exchange');
        $date = array_get($parameter, 'date');

        $value = DataService::history($stock, $exchange)->count(1)->to($date)->getClose();

        return new Price(key($value), array_first($value), $stock->currency->code);
    }


    public function previousPrice($stock, $exchange = null)
    {
        $value = DataService::history($stock, $exchange)->count(2)->getClose();

        return new Price(key($value), array_first($value), $stock->currency->code);
    }


    public function lowPrice($stock, $exchange)
    {
        $value = DataService::history($stock, $exchange)->count(1)->getLow();

        return new Price(key($value), array_first($value), $stock->currency->code);

    }


    public function highPrice($stock, $exchange)
    {
        $value = DataService::history($stock, $exchange)->count(1)->getHigh();

        return new Price(key($value), array_first($value), $stock->currency->code);
    }


    public function periodHigh($stock, $exchange, $count)
    {
        $value = max(DataService::history($stock, $exchange)->count($count)->getClose());

        return new Price(null, $value, $stock->currency->code);

    }


    public function periodLow($stock, $exchange, $count)
    {
        $value = min(DataService::history($stock, $exchange)->count($count)->getClose());

        return new Price(null, $value, $stock->currency->code);

    }


    public function periodDelta($stock, $exchange, $count)
    {
        $history = DataService::history($stock, $exchange)->count($count + 1)->getClose();
        $values = array_values($history);

        return new Price(key($history), $values[0]-$values[1], $stock->currency->code);
    }


    public function periodReturn($stock, $exchange, $count)
    {
        $value = DataService::history($stock, $exchange)->count($count)->getClose();

        return new Price(key($value), array_first($value), $stock->currency->code);
    }


    public function dataHistory($stock, $exchange)
    {
        $data = DataService::history($stock, $exchange);

        $datasource = DataService::getDatasource($stock, $exchange);

        return [
            'data' => $data->getClose(),
            'currency' => $stock->currency->code,
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
                'data' => DataService::history($stock, $exchange)->count($count)->getClose(),
                'datasourceId' => $datasource->id];
        };
        return $prices;
    }


    public function risk($stock)
    {
        $parameter = \Auth::user()->settings()->only(['confidence', 'period', 'history']);
        $parameter = array_replace_key($parameter, 'history', 'count');

        $risk = RiskService::instrumentVaR($stock, $parameter);

        return new Price(Carbon::now()->toDateString(), $risk, $stock->currency->code);
    }


    public function riskToPrice($stock, $exchange)
    {
        $risk = $this->risk($stock);
        $ratio = $risk->getValue() / $this->price($stock, $exchange)->getValue();

        return new Percent($risk->getDate(), $ratio);
    }


    public function expectedReturn($stock, $exchange)
    {
        $history = \Auth::user()->settings('history');

        $history = DataService::history($stock, $exchange)->count($history)->getClose();
        $expected = Circular::mean($history);

        return new Price(key($history), $expected, $stock->currency->code);
    }


    public function expectedReturnToPrice($stock, $exchange)
    {
        $return = $this->expectedReturn($stock, $exchange);
        $ratio = $return->getValue() / $this->price($stock, $exchange)->getValue();

        return new Percent($return->getDate(), $ratio);
    }
}