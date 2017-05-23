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
        return $this->divide(array_pad([], count($x), 1), array_column($x, 'Price'));
    }


    public function divide($x, $y)
    {
        $divide = [];
        $n = count($x);
        $m = count($y);

        if ($n != $m)
            throw new QuantModelException("vectors must have same length, was {$n} and {$m}");

        if (is_array($x[0])) {

            $array = $this->cbindArray($x, $y);
            foreach ($array as $row) { $divide[] = $row[0]/$row[1]; }

        } else {
            for ($i = 0; $i < $n; $i++) { $divide[] = $x[$i]/$y[$i]; }
        }

        return $divide;
    }


    /**
     * Combines two array into one array based on matched values for 'Date' column.
     * Both Arrays must have a 'Date' and a 'Price' column. The result is an date
     * indexed array with two columns representing the prices of initial array.
     *
     * @param $arr1
     * @param $arr2
     * @return array
     */
    public function cbindArray($arr1, $arr2)
    {
        $x = $this->indexedArray($arr1);
        $y = $this->indexedArray($arr2);

        $dates = array_intersect(array_keys($x), array_keys($y));

        $res = [];
        foreach ($dates as $date)
        {
            $res[$date] = ['Date' => $date, $x[$date], $y[$date]];
        }
        return $res;
    }


    protected function getCurrencyHistoryWithBase($base, $currency, $parameter): array
    {
        $ccy = CcyPair::whereOrigin($base)->whereTarget($currency)->first();

        if (is_null($ccy))
            throw new QuantModelException("No pathway is defined for currency pair {$base}{$currency}. Call 'QuandlECB::sync()' could be called");

        return Quandldata::getHistory($ccy->symbol(), $parameter);
    }

    private function indexedArray($array)
    {
        $keys = array_column($array, 'Date');
        $values = array_column($array, 'Price');

        return array_combine($keys, $values);
    }
}