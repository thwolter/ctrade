<?php


namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Entities\CcyPair;
use App\Entities\Dataset;
use App\Entities\Datasource;
use App\Repositories\Exceptions\MetadataException;
use App\Repositories\Quandl\Quandldata;
use MathPHP\Statistics\Average;
use MathPHP\Statistics\Circular;

class DataRepository
{

    protected $provider;
    

    public function __construct(Collection $datasource = null)
    {
        $this->provider = $this->dataProvider($datasource);
    }


    private function dataProvider($datasource)
    {
        $source = $datasource->first();
        $code = $source->provider->code;

        switch ($code) {
            case 'Quandl':
                return new Quandldata($source->dataset->code);
                break;
            case 'others';
                // define other data providers
                // break;
            default:
                throw new MetadataException("No financial available for provider code '{$code}''");
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