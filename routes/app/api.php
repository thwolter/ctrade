<?php

use App\Entities\Portfolio;

Route::get('/api/portfolio/history/value', function($id, $ccy, $form = 0, $to = 0) 
{
    dd($id);
    $portfolio = Portfolio::find($id)->first();
    $symbol = $portfolio->currencyCode().$ccy;
    
    return $portfolio->financial()->history($symbol, $from, $to);
});

Route::get('/api/portfolio/history/risk', function($id) 
{

});

Route::get('/api/portfolio/positions', function($id) 
{

});

Route::get('/api/instrument/history', function($id) 
{

});



