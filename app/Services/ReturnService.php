<?php

namespace App\Services;


use App\Classes\TimeSeries;
use App\Entities\Asset;
use App\Entities\Portfolio;
use App\Entities\Position;

class ReturnService
{
    /**
     * @param Portfolio|Asset|Position $entity
     * @param TimeSeries $timeSeries
     * @throws \Exception
     */
    public function return($entity, $timeSeries)
    {
        array_product($this->dailyReturns($entity, $timeSeries));
    }

    /**
     * @param $entity
     * @param $timeSeries
     * @return mixed
     * @throws \Exception
     */
    public function dailyReturns($entity, $timeSeries)
    {
        $function = 'dailyReturns' . class_basename($entity);

        return call_user_func($function, $entity, $timeSeries);
    }


    protected function dailyReturnsAsset($asset, $timeSeries)
    {

    }


    protected function dailyReturnsPortfolio($asset, $timeSeries)
    {

    }
}