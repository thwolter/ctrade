<?php


namespace App\Repositories\Contracts;

use Carbon\Carbon;

interface FinanceInterface
{
    public function price($symbol);

    public function type($symbol);

    public function currency($symbol);
    
    public function name($symbol);
    
    public function history($symbol, Carbon $from = null, Carbon $to = null);
    
   
}