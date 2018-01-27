<?php

namespace App\Services\ValueService;


use App\Classes\Output\Price;
use App\Entities\Portfolio;
use App\Facades\AccountService;
use App\Facades\DataService;
use App\Facades\MetricService\AssetMetricService;

class ValueService
{

    public function valueTotal(Portfolio $portfolio, $date = null)
    {
        $balance = AccountService::balance($portfolio, $date)->getValue();
        $valueAssets = $this->valueAssets($portfolio, $date)->getValue();

        return new Price($date, $valueAssets + $balance, $portfolio->currency->code);
    }


    /**
     * @param Portfolio $portfolio
     * @param string|null $date
     *
     * @return Price
     */
    public function valueAssets(Portfolio $portfolio, $date = null)
    {
        $value = 0;
        foreach ($portfolio->assets as $asset) {
            $price = DataService::priceAt($asset->positionable, $date)->getValue();
            $fxRate = 1;

            $value = $price * $asset->amountAt($date) * $fxRate;
            $value += $value;
        }

        return new Price($date, $value, $portfolio->currency->code);
    }

}