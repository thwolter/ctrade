<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 23.01.18
 * Time: 07:30
 */

namespace App\Services;


use App\Classes\Output\Price;
use App\Entities\Asset;
use App\Entities\Portfolio;
use Carbon\Carbon;

class AccountService
{

    /**
     * Return the Portfolio's cash position at a given date.
     *
     * @param Portfolio $portfolio
     * @param string|null $date
     * @return Price
     */
    public function portfolioBalance(Portfolio $portfolio, $date = null)
    {
        $date = Carbon::parse($date);

        $balance = $portfolio->payments()
            ->until($date)
            ->sum('amount');

        return new Price($date, (float)$balance, $portfolio->currency->code);
    }

    public function assetBalance(Asset $asset, $date = null)
    {
        $date = Carbon::parse($date);

        return $asset->payments()->until($date)->sum('amount');
    }
}