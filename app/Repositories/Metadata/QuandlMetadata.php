<?php

namespace App\Repositories\Metadata;


use App\Entities\Datasource;
use App\Entities\Provider;
use App\Repositories\Quandl\Quandldata;
use App\Repositories\Exceptions\MetadataException;
use Illuminate\Console\OutputStyle;
use Illuminate\Support\Facades\Log;

abstract class QuandlMetadata
{

    public $provider = 'Quandl';
    public $database;

  
    protected $perPage;
    protected $nextPage = 0;
    protected $totalPages = 2;
    protected $client;
   
   
    abstract public function saveItem($item);

    public function __construct()
    {
        if (!isset($this->database)) {
            throw new MetadataException("variable 'database' must be set");
        }
        
        $this->client = new \Quandl(env('QUANDL_API_KEY'), 'json');
        $this->client->timeout = 60;

    }



    public function createItemWithSource($item)
    {
        $instrument = $this->saveItem($item);

        if (is_null($instrument)) {
            Log::notice('symbol ' . $this->symbol($item) . ' not saved');
            return false;
        }
        Datasource::make($this->provider, $this->database, $this->symbol($item))
                ->assign($instrument);

        return true;
    }



    public function getItems($max = 100)
    {
        $this->max = $max;
        
        $json = $this->client->getList($this->database, $this->nextPage, $this->max);

        $array = json_decode($json, true);

        $this->nextPage = array_get($array, 'meta.next_page');
        $this->totalPages = array_get($array, 'meta.total_pages');

        return $array['datasets'];
    }


    public function hasDatasource($item)
    {
        return Datasource::exist($this->provider, $this->database, $this->symbol($item));
    }


    public function updateItem($item)
    {
        
    }
}