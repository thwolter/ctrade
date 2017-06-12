<?php


namespace App\Models;


use App\Models\Exceptions\QuantModelException;
use MathPHP\Statistics\Average;
use MathPHP\Statistics\Circular;


class QuantModel
{
    
    static public function ValueAtRisk($history, $conf = 1.64)
    {
        $quant = new self();

        $price = array_first($history);
        $returns = $quant->returns($history);

        return $conf * Circular::standardDeviation($returns) * $price;
    }


    public function returns($history)
    {
        $returns = [];

        $count = count($history) - 1;
        $keys = array_keys($history);

        for ($i = 0; $i < $count; $i++) {
            $returns[] = $history[$keys[$i]] / $history[$keys[$i + 1]] - 1;
        }
        return $returns;
    }

}