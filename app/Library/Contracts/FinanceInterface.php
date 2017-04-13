<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 13.04.17
 * Time: 09:53
 */

namespace App\Library\Contracts;


interface FinanceInterface
{
    public function summary($symbol);

    public function price($symbol);

    //public function history($symbol, \DateTime $startDate, \DateTime $endDate);
}