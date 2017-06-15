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


    public function __call($key, $arguments)
    {
        $parm = array_get($this->keys, $key);
        $item = $arguments[0];
        
        if (!is_null($parm)) {
            
            $match = preg_match($parm[1], array_get($item, $parm[0]), $matches); 
            $result = ($match) ? trim($matches[$parm[2]]) : null;
        
            return $this->check($key, $result, $item);
        }
    }
    
    /**
     * @param string $string
     * @param string $value
     * @param $item
     * @return null|string
     */
    private function check($string, $value, $item)
    {
        if (!empty($value)) return $value;

        Log::notice(sprintf("%s missing for %s -- %s",
            $string, $this->symbol($item), $this->description($item)
        ));
        
        return null;
    }
    
    
    public function createItemWithSource($item)
    {
        $instrument = $this->saveItem($item);

        if (is_null($instrument)) return false;

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
    
    private function unableLog($param, $item)
    {
        Log::notice(sprintf("'%s' missing for %s -- %s",
            $param, $this->symbol($item), $this->description($item)
        ));

        return null;
    }
}