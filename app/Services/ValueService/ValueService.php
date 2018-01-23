<?php

namespace App\Services\ValueService;


use App\Classes\Output\Price;
use App\Entities\Portfolio;
use App\Facades\AccountService;
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
            $value += AssetMetricService::value($asset)->getValue();
        }

        return new Price($date, $value, $portfolio->currency->code);
    }

}