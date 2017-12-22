<?php

namespace App\Presenters;


use App\Entities\Stock;
use Carbon\Carbon;
use Illuminate\Support\HtmlString;

class PortfolioPresenter extends Presenter
{


    public function value()
    {
        return $this->formatPrice(
            $this->metrics->value($this->entity)->getValue(), ['showNull' => true]
        );
    }


    public function cash()
    {
        return $this->formatPrice(
            $this->metrics->cash($this->entity)->getValue()
        );
    }


    public function stockTotal()
    {
        return $this->formatPrice(
            $this->metrics->total($this->entity, Stock::class)
        );
    }




    public function profit($days = null)
    {
        return $this->formatPrice($this->metrics->profit($this->entity, $days));
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
            $class = "";

        return new HtmlString(sprintf('<i class="%s" aria-hidden="true"></i> %s (%s)',
            $class,
            $this->formatPrice(abs($profit), ['showNull' => true]),
            $this->formatPercentage($percent)
        ));
    }

    public function risk()
    {
        return $this->formatPrice($this->metrics->risk($this->entity)->getValue());
    }


    /*
    |--------------------------------------------------------------------------
    | DATES
    |--------------------------------------------------------------------------
    */

    public function updatedRisk()
    {
        return $this->formatDate(
            array_last(array_keys($this->entity->keyFigure('risk')->values))
        );
    }

    public function updatedValue()
    {
        return $this->formatDate(
            array_last(array_keys($this->entity->keyFigure('value')->values))
        );
    }

    public function updatedToday()
    {
        return $this->formatDate(
            Carbon::now()
        );
    }

    public function updatedReturn()
    {
        return $this->formatDate(
            array_last(array_keys($this->entity->keyFigure('value')->values))
        );
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