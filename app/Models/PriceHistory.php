<?php


namespace App\Models;

use Carbon\Carbon;


class PriceHistory
{
    
    protected $data;
    protected $column;
    
    
    public function __construct(array $history, $column)
    {
        $this->data = $this->normalize($history, $column);
    }
    
    
    private function normalize($history, $column)
    {
        return array_combine(
            array_column($history, 0), 
            array_column($history, $column)
        );
    }
    
    public function history($dates = null)
    {
        if (is_null($dates)) 
            return $this->data;
        else {
            return $this->forDates($dates);
        }
    }
    
    public function price()
    {
        return [key($this->data) => head($this->data)];
    }
    
    public function priceDate()
    {
        return key($this->data);
    }
        
    private function forDates(array $keys)
    {
        $result = [];

        foreach ($keys as $key) {
            
            $result[$key] = array_get($this->data, $key);
            
            if (is_null($result[$key])) {
                
                $date = new Carbon($key);
                
                while (is_null($result[$key])) {
                    $result[$key] = array_get($this->data, $date->subDay(1)->toDateString());
                }
            }
        }
        
        return $result;
    }
}