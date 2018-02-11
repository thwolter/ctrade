<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 23.01.18
 * Time: 07:30
 */

namespace App\Services;


use App\Classes\Output\Price;
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
    public function balance(Portfolio $portfolio, $date = null)
    {
        $date = Carbon::parse($date);

        $cash = $portfolio->payments()
            ->where('executed_at', '<=', $date->endOfDay())
            ->sum('amount');

        return new Price($date, $cash, $portfolio->currency->code);
    }
}