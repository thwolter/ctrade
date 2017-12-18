<?php


namespace App\Presenters;


use App\Services\DataService;
use Carbon\Carbon;

class StockPresenter extends Presenter
{

    public function isin()
    {
        return $this->entity->isin;
    }


    public function price($exchange = null)
    {
        return $this->formatPrice(
            $this->metric->price($exchange)
        );
    }


    public function priceDate($exchange = null)
    {
        return $this->formatDate(
            key($this->metric->price($exchange))
        );
    }


    public function previousPrice($exchange = null)
    {
        return $this->formatPrice(
            $this->metric->previousPrice($exchange)
        );
    }


    public function minPrice($exchange)
    {
        return $this->formatPrice(
            $this->dataService->history($this->entity, $exchange)->count(1)->column('Low')->get()
        );
    }

    public function maxPrice($exchange)
    {
        return $this->formatPrice(
            $this->dataService->history($this->entity, $exchange)->count(1)->column('High')->get()
        );
    }


    public function periodLow($exchange, $count)
    {
        return $this->formatPrice(
            min($this->dataService->priceHistory($this->entity, ['count' => $count, 'exchange' => $exchange]))
        );
    }


    public function periodHigh($exchange, $count)
    {
        return $this->formatPrice(
            max($this->dataService->priceHistory($this->entity, ['count' => $count, 'exchange' => $exchange]))
        );
    }


    public function periodReturn($exchange, $count)
    {
        $prices = $this->dataService->priceHistory($this->entity, ['count' => $count, 'exchange' => $exchange]);

        return $this->formatPercentage(
            array_last($prices) ? array_first($prices)/array_last($prices) - 1 : null
        );
    }



   /* public function risk()
    {
        return $this->formatPrice($this->entity->price(), $this->entity->currency->code);
    }*/

}