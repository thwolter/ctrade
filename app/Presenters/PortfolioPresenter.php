<?php

namespace App\Presenters;


use App\Classes\Output\Price;
use App\Entities\Limit;
use App\Entities\Stock;
use App\Facades\MetricService\LimitMetricService;
use App\Facades\MetricService\PortfolioMetricService;
use Carbon\Carbon;
use Classes\Output\Output;
use Illuminate\Support\HtmlString;

class PortfolioPresenter extends Presenter
{

    private $utilisation;


    public function value()
    {
        return $this->metrics->value($this->entity)->formatValue();
    }


    public function cash()
    {
        return $this->metrics->cash($this->entity)->formatValue();
    }


    public function stockTotal()
    {
        return $this->metrics->total($this->entity, Stock::class)->formatValue();
    }


    public function profit($days = null)
    {
        return $this->metrics->profit($this->entity, $days)->formatValue();
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
            $profit->formatValue(),
            $percent->formatValue()
        ));
    }

    public function risk($digits = 2)
    {
        return $this->metrics->risk($this->entity)->formatValue($digits);
    }


    public function limitUtilisation()
    {
        return $this->getLimitUtilisation()->formatValue();
    }


    public function limitUtilisationNumber()
    {
        return $this->getLimitUtilisation()->getValue();
    }


    /**
     * Return the amount of portfolio's limit.
     *
     * @param int $digits
     *
     * @return string
     * @throws \Throwable
     */
    public function limitAmount($digits = 2)
    {
        $amount = new Price(null, $this->getPortfolioLimit()->value, $this->entity->currency->code);

        return $amount->formatValue($digits);
    }

    /**
     * Return the portfolio's limit.
     *
     * @return mixed
     */
    private function getLimitUtilisation()
    {
        if (!$this->utilisation) {
            $limit = $this->getPortfolioLimit();
            $this->utilisation = LimitMetricService::utilisation($limit);
        }

        return $this->utilisation;
    }

    /**
     * Return the portfolio's limit.
     *
     * @return Limit
     */
    private function getPortfolioLimit()
    {
        return $this->entity->limits->first();
    }


    /*
    |--------------------------------------------------------------------------
    | DATES
    |--------------------------------------------------------------------------
    */

    public function updatedRisk()
    {
        return PortfolioMetricService::risk($this->entity)->formatDate();
    }

    public function updatedValue()
    {
        return PortfolioMetricService::value($this->entity)->formatDate();
    }

    public function updatedToday()
    {
        return (new \App\Classes\Output\Output(Carbon::now()->toDateString()))->formatDate();
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