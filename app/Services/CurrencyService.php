<?php

namespace App\Services;


use App\Entities\CcyPair;
use App\Facades\DataService;

class CurrencyService
{

    public function priceAt($origin, $target, $date)
    {
        $ccyPair = CcyPair::whereOrigin($origin)->whereTarget($target)->first();

        return DataService::priceAt($ccyPair, $date);
    }
}