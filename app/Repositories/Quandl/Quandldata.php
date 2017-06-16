<?php

namespace App\Repositories\Quandl;

use App\Entities\Database;
use App\Entities\Dataset;
use App\Models\Exceptions\QuandlException;
use App\Entities\Datasource;
use Carbon\Carbon;
use App\Models\PriceHistory;

class Quandldata
{

    protected $priceColumnNames = ['Last', 'Close'];

    protected $client;
    protected $source;
   
    protected $history;
    
    protected $relax = true;
    protected $limit = 250;


    /**
     * Quandldata constructor.
     *
     * @param string $code of a dataset
     * @param array $parameter
     */
    public function __construct(String $code, $parameter = ['limit' => 250])
    {
        if (!array_has($parameter, 'limit')) 
            $parameter['limit'] = $this->limit;
        
        $this->client = new \Quandl(env('QUANDL_API_KEY'), 'json');
        $this->source = Datasource::withDatasetOrFail($code);
        
        $this->history = $this->fetchCachedHistory($parameter);
    }


    public function price()
    {
        return $this->history->price();
    }

   
    public function history($dates = null)
    {
        return $this->history->data($dates);
    }


    public function relax($relax)
    {
        $this->relax = $relax;
        return $this;
    }
    
    
    static public function refreshCache($code, $relax = true)
    {
        return (new self($code))->relax($relax)->history();
    }
    

    
    private function fetchCachedHistory($parameter)
    {
        $key = "Quandl/{$this->quandlCode()}";
        
        if (\Cache::store('database')->has($key) and $this->relax) {
            
            $data = \Cache::store('database')->get($key);
            
        } else { 
        
            $data = $this->fetchHistory($parameter);
            
            $expiresAt = Carbon::now()->endOfDay();
            \Cache::store('database')->put($key, $data, $expiresAt);
        }
        
        return $data;
    }


    private function fetchHistory($parameter)
    {
        $json = $this->client->getSymbol($this->quandlCode(), $parameter);

        if (!is_null($this->client->error)) 
            throw new QuandlException($this->client->error);
        
        $array = json_decode($json, true);

        $prices = array_get($array, 'dataset.data');
        $column = $this->priceColumn(array_get($array, 'dataset.column_names'));
        
        return new PriceHistory($prices, $column);
    }


    private function quandlCode()
    {
        $database_code = $this->source->first()->database->code;
        $dataset_code = $this->source->first()->dataset->code;

        return "{$database_code}/{$dataset_code}";
    }
    
    
    private function priceColumn($columnNames)
    {
        $i = 0;
        $count = count($this->priceColumnNames);

        while (! isset($column) and $i < $count) {
            $column = array_search($this->priceColumnNames[$i++], $columnNames);
        }

        return ($column) ? $column : 1;
    }
}