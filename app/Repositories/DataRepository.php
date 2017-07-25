<?php


namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Exceptions\MetadataException;
use App\Repositories\Quandl\Quandldata;


class DataRepository
{

    protected $provider;
    
    protected $parameter = [
        'limit' => 500
    ];
    

    public function __construct(Collection $sources)
    {
        $this->provider = $this->dataProvider($sources);
    }


    public function price()
    {
        return $this->provider->price();
    }


    public function history($dates = null)
    {
        return $this->provider->history($dates);
    }


    private function dataProvider($datasource)
    {
        $source = $datasource->first();
        $code = $source->provider->code;

        switch ($code) {
            case 'Quandl':
                return new Quandldata($source->dataset->code, $this->parameter);
                break;
            case 'others':
                // define other data providers
                // break;
            default:
                throw new MetadataException("No financial available for provider code '{$code}''");
        }
    }
}