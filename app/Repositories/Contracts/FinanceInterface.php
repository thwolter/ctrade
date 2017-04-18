<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 13.04.17
 * Time: 09:53
 */

namespace App\Repositories\Contracts;


interface FinanceInterface
{
    public function price($symbol);

    public function type($symbol);

    public function currency($symbol);

    //public function history($symbol, \DateTime $startDate, \DateTime $endDate);
}