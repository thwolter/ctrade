<?php

namespace App\Services;


use App\Classes\Output\Price;
use App\Classes\TimeSeries;
use App\Entities\CcyPair;
use App\Entities\Currency;
use App\Facades\DataService;

class CurrencyService
{

    public function priceAt($origin, $target, $date)
    {
        $price = $this->history($origin, $target)->to($date)->getLatestClose();

        return Price::fromArray($price, $target);
    }


    /**
     * @param string|Currency $origin
     * @param string|Currency $target
     *
     * @return TimeSeries
     */
    public function history($origin, $target)
    {
        $ccyPair = $this->getCcyPair($origin, $target);

        if ($ccyPair) {
            return DataService::history($ccyPair);

        } else {
            $ccyPair = $this->getCcyPairInverse($origin, $target);
            return DataService::history($ccyPair)->reciprocal();
        }
    }


    /**
     * @param $origin
     * @param $target
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    private function getCcyPair($origin, $target)
    {
        return CcyPair::whereOrigin($origin)->whereTarget($target)->first();
    }


    /**
     * @param $origin
     * @param $target
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    private function getCcyPairInverse($origin, $target)
    {
        return CcyPair::whereOrigin($target)->whereTarget($origin)->first();
    }
}