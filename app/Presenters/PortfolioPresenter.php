<?php

namespace App\Presenters;


use App\Classes\Output\Output;
use App\Classes\Output\Price;
use App\Facades\AccountService;
use App\Facades\PortfolioService;
use App\Facades\RiskService\RiskService;
use Carbon\Carbon;
use Illuminate\Support\HtmlString;

class PortfolioPresenter extends Presenter
{

    private $risk;


    public function value()
    {
        return PortfolioService::value($this->entity);
    }


    public function balance()
    {
        return PortfolioService::balance($this->entity);
    }


    public function absoluteReturn($date)
    {
        return PortfolioService::absoluteReturn($this->entity, $date);
    }


    public function htmlProfit($days)
    {
        $profit = PortfolioService::absoluteReturn($this->entity, $days);

        if (!$profit) return null;

        $percent = PortfolioService::absoluteReturn($this->entity, $days, true)->getValue();

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


    /**
     * @return Price
     * @throws \Exception
     */
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