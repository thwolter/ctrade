<?php

namespace App\Services\ValueService;


use App\Classes\Output\Price;
use App\Entities\Portfolio;
use App\Facades\AccountService;
use App\Facades\DataService;
use App\Facades\AssetService;

class ValueService
{

    public function portfolioValue(Portfolio $portfolio, $date = null)
    {
        $balance = AccountService::balance($portfolio, $date)->getValue();
        $valueAssets = $this->portfolioAssets($portfolio, $date)->getValue();

        return new Price($date, $valueAssets + $balance, $portfolio->currency->code);
    }


    /**
     * @param Portfolio $portfolio
     * @param string|null $date
     *
     * @return Price
     */
    public function portfolioAssets(Portfolio $portfolio, $date = null)
    {
        $value = 0;
        foreach ($portfolio->assets as $asset) {

            $fxRate = 1;
            $value += AssetService::valueAt($asset, $date)->getValue() * $fxRate;
        }

        return new Price($date, $value, $portfolio->currency->code);
    }

}