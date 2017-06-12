<?php


namespace App\Models;


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
    
    public function data()
    {
        return $this->data;
    }
    
    public function price()
    {
        return head($this->data);
    }
    
    public function priceDate()
    {
        return key($this->data);
    }
        
}