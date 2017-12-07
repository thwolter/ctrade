<?php

namespace App\Presenters;


use App\Repositories\RiskRepository;
use Carbon\Carbon;

class PortfolioPresenter extends Presenter
{

    protected $repo;


    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->repo = new RiskRepository($this->entity);
    }

    public function cash()
    {
        return $this->formatPrice($this->entity->cash(), $this->entity->currency->code);
    }

    public function stockTotal()
    {
        return $this->formatPrice($this->entity->total(\App\Entities\Stock::class), $this->entity->currency->code);
    }

    public function total()
    {
        return $this->formatPrice($this->entity->total(), $this->entity->currency->code);
    }

    public function valueChange($days)
    {
        return $this->formatPrice($this->repo->valueChange($days));
    }

    public function risk()
    {
        $risk = $this->repo->portfolioRisk();

        return $this->formatPrice($risk, $this->entity->currency->code);
    }

    public function return()
    {
        $return = $this->repo->portfolioReturn();

        return $this->formatPercentage($return);
    }

    public function profit()
    {
        $profit = $this->repo->portfolioProfit();

        return $this->formatprice($profit, $this->entity->currency->code);
    }

    public function updatedRisk()
    {
        $date = array_last(array_keys($this->entity->keyFigure('risk')->values));
        return $this->formatDate($date);
    }

    public function updatedValue()
    {
        $date = array_last(array_keys($this->entity->keyFigure('value')->values));
        return $this->formatDate($date);
    }

    public function updatedToday()
    {
        $date = Carbon::now();
        return $this->formatDate($date);
    }

    public function updatedReturn()
    {
        $date = array_last(array_keys($this->entity->keyFigure('value')->values));
        return $this->formatDate($date);
    }

    public function image()
    {
        $url = $this->entity->imageUrl;
        return (! is_null($url)) ? asset('storage/'.$url) : asset('img/portfolios/bg-1.jpg');
    }

    public function description()
    {
        $decription = $this->entity->description;

        $text = $decription
            ? $decription
            : implode(', ', $this->entity->assets->pluck('name')->all());

        return $text
            ? mb_strimwidth($text, 0, 50, "...")
            : 'Portfolio enthält noch keine Assets.';
    }

}