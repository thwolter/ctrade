<?php

namespace App\Presenters;


use App\Classes\Output\Output;
use App\Classes\Output\Price;
use App\Entities\Stock;
use App\Facades\AccountService;
use App\Facades\RiskService\RiskService;
use App\Facades\ValueService\ValueService;
use Carbon\Carbon;
use Illuminate\Support\HtmlString;

class PortfolioPresenter extends Presenter
{

    private $risk;


    public function value()
    {
        return ValueService::valueTotal($this->entity)->formatValue();
    }


    public function cash()
    {
        return AccountService::balance($this->entity)->formatValue();
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

    /**
     * @param int $digits
     * @return string
     * @throws \Throwable
     */
    public function risk($digits = 2)
    {
        return $this->getPortfolioVaR()->formatValue($digits);
    }


    private function getPortfolioVaR()
    {
        if (!$this->risk && $this->entity->assets->count()) {

            $this->risk = new Price(
                Carbon::now()->toDateString(),
                RiskService::portfolioVaR($this->entity, $this->entity->riskParameter()),
                $this->entity->currency->code
            );
        }
        return $this->risk;
    }


    /*
    |--------------------------------------------------------------------------
    | DATES
    |--------------------------------------------------------------------------
    */

    public function updatedRisk()
    {
        return $this->getPortfolioVaR()->formatDate();
    }

    public function updatedToday()
    {
        return (new Output(Carbon::now()->toDateString()))->formatDate();
    }

    public function updatedReturn()
    {
        return $this->updatedValue();
    }

    public function updatedValue()
    {
        return ValueService::valueTotal($this->entity)->formatDate();
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