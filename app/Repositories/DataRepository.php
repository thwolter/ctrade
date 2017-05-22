<?php


namespace App\Repositories;


use App\Entities\CcyPair;
use App\Entities\Dataset;
use App\Models\Pathway;
use App\Repositories\Exceptions\MetadataException;
use App\Repositories\Quandl\Quandldata;
use MathPHP\Statistics\Average;
use MathPHP\Statistics\Circular;

class DataRepository
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
}