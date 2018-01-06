<?php

namespace App\Services\RiskService;


use App\Entities\Asset;
use MathPHP\Statistics\Descriptive;

interface RiskInterface
{
    public function delta(Asset $asset, $parameter);

    public function VaR(Asset $asset, $parameter);

}