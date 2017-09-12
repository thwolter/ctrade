<?php

namespace App\Presenters;


use App\Repositories\RiskRepository;
use Carbon\Carbon;

class Portfolio extends Presenter
{

    public function cash()
    {
        return $this->formatPrice($this->entity->cash(), $this->entity->currencyCode());
    }

    public function stockTotal()
    {
        return $this->formatPrice($this->entity->total(\App\Entities\Stock::class), $this->entity->currencyCode());
    }

    public function total()
    {
        return $this->formatPrice($this->entity->total(), $this->entity->currencyCode());
    }

    public function risk()
    {
        $repo = new RiskRepository($this->entity);
        $risk = $repo->portfolioRisk();

        return $this->formatPrice($risk, $this->entity->currencyCode());
    }

    public function return()
    {
        $repo = new RiskRepository($this->entity);
        $return = $repo->portfolioReturn();

        return $this->formatPercentage($return);
    }

    public function profit()
    {
        $repo = new RiskRepository($this->entity);
        $profit = $repo->portfolioProfit();

        return $this->formatprice($profit, $this->entity->currencyCode());
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
        $description = $this->entity->description;
        if ($description) {
            return '<p>$description</p>';
        } else {
            return '<p style="color: lightgrey;">Keine Beschreibung vorhanden.</p>';
        }
    }

}