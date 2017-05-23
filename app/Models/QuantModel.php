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
        $price = array_first($x);

        $count = count($x) - 1;
        $keys = array_keys($x);
        
        $return = [];
        for ($i = 0; $i < $count; $i++) {
            $return[] = $x[$keys[$i]] / $x[$keys[$i+1]] - 1;
        }

        $VaR = 1.64 * Circular::standardDeviation($return) * $price;
        $mean = Average::mean($return);

        $result = [
            'VaR' => $VaR,
            'mean' => $mean,
            'expect' => $price * (1 + $mean),
            'range' => [$price - $VaR, $price + $VaR],
            'price' => $price
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
        return self::ccyHistory($origin, $target, ['limit' => 1]);
    }


    protected function inverse($x)
    {
        $z = $this->arrayPadWithDate($x, 1);
        
        return $this->divide($z, $x);
    }


    public function divide($x, $y)
    {
        $divide = [];
        $n = count($x);
        $m = count($y);

        if ($n != $m)
            throw new QuantModelException("vectors must have same length, was {$n} and {$m}");

        //$z = $this->cbindArray($x, $y);
        
        $keys = array_keys($x);
        for ($i = 0; $i < $n; $i++) 
        { 
            $divide[$keys[$i]] = $x[$keys[$i]]/$y[$keys[$i]]; 
            
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
    public function cbindArray($x, $y)
    {
        $dates = array_intersect(array_keys($x), array_keys($y));

        $res = [];
        foreach ($dates as $date)
        {
            $res[$date] = [$x[$date], $y[$date]];
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
    
    
    private function arrayPadWithDate($x, $value)
    {
        $z = [];
        foreach ($x as $key=>$value)
        {
            $z[$key] = 1;    
        }
        
        return $z;
    }
}