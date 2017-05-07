<?php

namespace App\Repositories\Quandl;

use App\Repositories\Contracts\FinanceInterface;


require_once base_path()."/vendor/dannyben/php-quandl/QuandlMetadataMetadata.php";

class StockFinancial extends FinanceInterface
{

    private $client;
    
    
    public function __construct()
    {
        $this->client = new Quandl(env('QUANDL_API_KEY'), "json");
        
    }
    
    
    public function price($symbol)
    {
        
    }
    
    

}