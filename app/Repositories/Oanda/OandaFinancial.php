<?php

namespace App\Repositories\Oanda;

use Carbon\Carbon;

class OandaFinancial
{
    public $url = "https://www.oanda.com/fx-for-business/". 
                     "historical-rates/api/update/?&widget=1". "&source=OANDA&display=absolute&adjustment=0". 
                     "&data_range=c". "&quote_currency=%s".
                     "&start_date=%s". "&end_date=%s". "&period=daily". 
                     "&price=mid". "&view=table". "&base_currency_0=%s";
    
    
    
    static public function history()
    {
        return new OandaFinancial;
    }
    
    
    public function get($symbol)
    {
        $currencyPair = str_split($symbol, 3);
        $urlString = sprintf($this->url,
            $currencyPair[1], 
            Carbon::today()->addDay(-255)->toDateString(), 
            Carbon::today()->toDateString(), 
            $currencyPair[0]);
            
        $data = json_decode(file_get_contents($urlString), true)['widget'][0]['data'];
        
        return $this->prepare($data, $symbol);

    }
    
    
    public function prepare($data, $symbol)
    {
        $dt = Carbon::now();
        $array = [];
        
        foreach ($data as $row)
        {
            $newrow = [$symbol, $dt->timestamp($row[0]/1000)->toDateString(), $row[1]];
            $array[] = $newrow;
        }
        
        return json_encode($array);
    }
    
}
