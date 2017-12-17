<?php


namespace App\Presenters;


use App\Services\DataService;
use Carbon\Carbon;

class StockPresenter extends Presenter
{

    protected $dataService;



    public function __construct($entity)
    {
        parent::__construct($entity);

        $this->dataService = app()->make(DataService::class);
    }


    public function priceDate()
    {
        return $this->formatDate(
            key($this->dataService->price($this->entity))
        );
    }


    public function price()
    {
        return $this->formatPrice(
            $this->dataService->price($this->entity)
        );
    }


    public function previousPrice()
    {
        $this->dataService->priceHistory($this->entity, ['count' => 1]);
        return $this->formatPrice(
            array_last($this->dataService->priceHistory($this->entity, ['count' => 2]))
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
            array_first($prices)/array_last($prices) - 1
        );
    }



   /* public function risk()
    {
        return $this->formatPrice($this->entity->price(), $this->entity->currency->code);
    }*/

}