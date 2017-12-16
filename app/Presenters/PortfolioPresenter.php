<?php

namespace App\Presenters;


use App\Services\MetricServices\PortfolioMetricService;
use App\Entities\Stock;
use Carbon\Carbon;
use Illuminate\Support\HtmlString;

class PortfolioPresenter extends Presenter
{

    protected $metrics;


    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->metrics = app()->make(PortfolioMetricService::class);
    }


    /*
    |--------------------------------------------------------------------------
    | CALCULATED
    |--------------------------------------------------------------------------
    */

    public function cash()
    {
        return $this->formatPrice($this->entity->cash());
    }

    public function stockTotal()
    {
        return $this->formatPrice($this->entity->total(Stock::class));
    }

    public function total()
    {
        return $this->formatPrice($this->entity->total(), ['showNull' => true]);
    }

    public function profit($days = null)
    {
        return $this->formatPrice($this->service->profit($days));
    }

    public function htmlProfit($days)
    {
        $profit = $this->metrics->profit($this->entity, $days);
        $percent = $this->metrics->profit($this->entity, $days, true);

        if ($profit > 0)
            $class = "fa fa-caret-up g-color-green";
        elseif ($profit < 0)
            $class = "fa fa-caret-down g-color-red";
        elseif ($profit === 0)
            $class = "fa fa-caret-down g-color-red";
        else
            $class="";

        return new HtmlString(sprintf('<i class="%s" aria-hidden="true"></i> %s (%s)',
            $class,
            $this->formatPrice(abs($profit), ['showNull' => true]),
            $this->formatPercentage($percent)
        ));
    }

    public function risk()
    {
        return $this->formatPrice($this->metrics->risk($this->entity));
    }


    /*
    |--------------------------------------------------------------------------
    | DATES
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | OTHERS
    |--------------------------------------------------------------------------
    */

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