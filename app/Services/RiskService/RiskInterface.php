<?php

namespace App\Services\RiskService;


use App\Entities\Asset;
use MathPHP\Statistics\Descriptive;

interface RiskInterface
{
    public function assetDelta($asset, $parameter);

    public function assetVaR($asset, $parameter);

    public function instrumentDelta($entity, $parameter);

    public function instrumentVaR($entity, $parameter);

}