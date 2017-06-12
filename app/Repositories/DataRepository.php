<?php


namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Exceptions\MetadataException;
use App\Repositories\Quandl\Quandldata;


class DataRepository
{

    protected $provider;
    
    protected $paramter = [
        'limit' => 250
    ];
    

    public function __construct(Collection $sources)
    {
        $this->provider = $this->dataProvider($sources);
    }


    public function price()
    {
        return $this->provider->price();
    }


    public function history()
    {
        return $this->provider->history();
    }


    private function dataProvider($datasource)
    {
        $source = $datasource->first();
        
        switch ($code) {
            case 'Quandl':
                return new Quandldata($source->dataset->code, $this->paramter);
                break;
            case 'others';
                // define other data providers
                // break;
            default:
                $code = $source->provider->code;
                throw new MetadataException("No financial available for provider code '{$code}''");
        }
    }
}