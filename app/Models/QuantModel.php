<?php


namespace App\Models;


use App\Entities\CcyPair;
use App\Repositories\Quandl\Quandldata;
use MathPHP\Statistics\Average;
use MathPHP\Statistics\Circular;

class QuantModel
{
    static public function ValueAtRisk($history)
    {
        $x = $history;

        $count = count($x) - 1;

        $return = [];
        for ($i = 0; $i < $count; $i++) {
            $return[] = $x[$i] / $x[$i+1] - 1;
        }

        $VaR = 2.33 * Circular::standardDeviation($return) * $x[0];
        $mean = Average::mean($return);

        $result = [
            'VaR' => $VaR,
            'mean' => $mean,
            'expect' => $x[0] * (1 + $mean),
            'range' => [$x[0] - $VaR, $x[0] + $VaR],
            'price' => $x[0]
        ];

        return $result;
    }

    static public function ccyHistory($origin, $target, $parameter = ['limit' => 250])
    {
        $base = 'EUR';

        if ($origin == $base) {
            $ccy = CcyPair::whereOrigin($base)->whereTarget($target)->first();
            return Quandldata::make($ccy->pathway()->first())->history($parameter);
        }

        if ($target == $base) {
            $ccy = CcyPair::whereOrigin($base)->whereTarget($origin)->first();
            $hist = Quandldata::make($ccy->pathway()->first())->history($parameter);

            $histInverse = [];
            foreach ($hist as $x) {
                $histInverse[] = 1/$x;
            }
            return $histInverse;
        }

        $ccy1 = CcyPair::whereOrigin($base)->whereTarget($target)->first();
        $hist1 = Quandldata::make($ccy1->pathway()->first())->history($parameter);

        $ccy2 = CcyPair::whereOrigin($base)->whereTarget($origin)->first();
        $hist2 = Quandldata::make($ccy2->pathway()->first())->history($parameter);

        $x = [];
        $count = count($hist1);
        for ($i = 0; $i < $count; $i++) {
            $x[$i] = $hist2[$i]/$hist1[$i];
        }

        return $x;
    }

    static public function ccyPrice($origin, $target)
    {
        return self::ccyHistory($origin, $target, ['limit' => 1])[0];
    }
}