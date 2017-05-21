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

    protected $provider;

    public function __construct(Pathway $pathway = null)
    {
        $this->provider = $this->dataProvider($pathway);
    }

    private function dataProvider($pathway)
    {
        $path = $pathway->first();

        switch ($path->provider->code) {
            case 'Quandl':
                return new Quandldata($path->dataset->code);
                break;
            case 'others';
                // define other data providers
                // break;
            default:
                throw new MetadataException("No financial available for provider code '{$this->providerCode}''");
        }
    }

    public function price()
    {
        return $this->provider->price();
    }


    public function history($parameter = ['limit' => 250])
    {
        return $this->provider->history($parameter);
    }


}