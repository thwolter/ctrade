<?php


namespace App\Models;


use App\Entities\CcyPair;
use App\Models\Exceptions\QuantModelException;
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
        $model = new QuantModel();
        return $model->getCurrencyHistory($origin, $target, $parameter);
    }


    public function getCurrencyHistory($origin, $target, $parameter = ['limit' => 250])
    {
        if ($origin == $target) {
            return array_pad([], $parameter['limit'], 1);
        }

        $base = 'EUR';

        if ($origin == $base) {
            $hist = $this->getCurrencyHistoryWithBase($base, $target, $parameter);
            return $hist;
        }

        if ($target == $base) {
            $hist = $this->getCurrencyHistoryWithBase($base, $origin, $parameter);
            return $this->inverse($hist);
        }

        $hist1 = $this->getCurrencyHistoryWithBase($base, $target, $parameter);
        $hist2 = $this->getCurrencyHistoryWithBase($base, $origin, $parameter);

        return $this->divide($hist1, $hist2);
    }


    static public function ccyPrice($origin, $target)
    {
        return self::ccyHistory($origin, $target, ['limit' => 1])[0];
    }


    protected function inverse($x)
    {
        return $this->divide(array_pad([], count($x), 1), $x);
    }


    public function divide($x, $y)
    {
        $divide = [];
        $n = count($x);
        $m = count($y);

        if ($n != $m)
            throw new QuantModelException("vectors must have same length, was {$n} and {$m}");

        for ($i = 0; $i < $n; $i++)
        {
            $divide[] = $x[$i]/$y[$i];
        }
        return $divide;
    }

    protected function getCurrencyHistoryWithBase($base, $currency, $parameter): array
    {
        $ccy = CcyPair::whereOrigin($base)->whereTarget($currency)->first();
        return Quandldata::getHistory($ccy->symbol(), $parameter);
    }
}