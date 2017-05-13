<?php


namespace App\Repositories;


use App\Entities\CcyPair;
use App\Entities\Dataset;
use App\Models\Pathway;
use App\Repositories\Exceptions\MetadataException;
use App\Repositories\Quandl\Quandldata;
use MathPHP\Statistics\Average;
use MathPHP\Statistics\Circular;

class FinanceRepository
{

    protected $pathway;

    public function __construct(Pathway $pathway = null)
    {
        $this->pathway = $pathway;
    }

    public function dataRepository()
    {
        $path = $this->pathway->first();
        $code = $path->provider->code;

        switch ($code) {
            case 'Quandl':
                return Quandldata::make($path);
                break;
            case 'others'; // break;
            default:
                throw new MetadataException("No financial available for provider code '{$code}''");
        }
    }

    public function price()
    {
        return $this->dataRepository()->price();
    }


    public function history($parameter)
    {
        return $this->dataRepository()->history($parameter);
    }


    public function ValueAtRisk()
    {
        $x = $this->history(['limit' => 250]);

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

    public function ccyHistory($origin, $target, $parameter = ['limit' => 250])
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

    public function ccyPrice($origin, $target)
    {
        return $this->ccyHistory($origin, $target, ['limit' => 1])[0];
    }
}