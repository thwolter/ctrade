<?php

namespace App\Presenters;


use App\Classes\Price;
use App\Entities\Stock;
use App\Facades\MetricService\PortfolioMetricService;
use Carbon\Carbon;
use Illuminate\Support\HtmlString;

class PortfolioPresenter extends Presenter
{


    public function value()
    {
        return $this->metrics->value($this->entity)->toLocalCurrencyFormat();
    }


    public function cash()
    {
        return $this->metrics->cash($this->entity)->toLocalCurrencyFormat();
    }


    public function stockTotal()
    {
        return $this->metrics->total($this->entity, Stock::class)->toLocalCurrencyFormat();
    }


    public function profit($days = null)
    {
        return $this->metrics->profit($this->entity, $days)->toLocalCurrencyFormat();
    }


    public function htmlProfit($days)
    {
        $profit = $this->metrics->profit($this->entity, $days);

        if (!$profit) return null;

        $percent = $this->metrics->profit($this->entity, $days, true)->getValue();

        if ($profit->getValue() > 0)
            $class = "fa fa-caret-up g-color-green";
        elseif ($profit->getValue() < 0)
            $class = "fa fa-caret-down g-color-red";
        elseif ($profit->getValue() === 0)
            $class = "fa fa-caret-down g-color-red";
        else
            $class = "";

        return new HtmlString(sprintf('<i class="%s" aria-hidden="true"></i> %s (%s)',
            $class,
            $profit->toLocalCurrencyFormat(),
            $percent->toLocalPercentageFormat()
        ));
    }

    public function risk()
    {
        return $this->metrics->risk($this->entity)->toLocalCurrencyFormat();
    }


    /*
    |--------------------------------------------------------------------------
    | DATES
    |--------------------------------------------------------------------------
    */

    public function updatedRisk()
    {
        return PortfolioMetricService::risk($this->entity)->toLocalDateFormat();
    }

    public function updatedValue()
    {
        return PortfolioMetricService::value($this->entity)->toLocalDateFormat();
    }

    public function updatedToday()
    {
        return Price::make(Carbon::now()->toDateString(), 0)->toLocalDateFormat();
    }

    public function updatedReturn()
    {
        return $this->updatedValue();
    }


    /*
    |--------------------------------------------------------------------------
    | OTHERS
    |--------------------------------------------------------------------------
    */

    public function image()
    {
        $url = $this->entity->imageUrl;
        return (!is_null($url)) ? asset('storage/' . $url) : asset('img/portfolios/bg-1.jpg');
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