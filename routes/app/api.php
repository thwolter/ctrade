<?php

use App\Entities\Portfolio;
use Illuminate\Http\Request;

Route::get('api/portfolio/history/value', function(Request $request)
{
    $portfolio = Portfolio::find($id)->first();
    $symbol = $portfolio->currencyCode().$ccy;
    
    return $portfolio->financial()->history($symbol, $from, $to);
});

Route::get('/api/portfolio/history/risk', function($id) 
{

});



Route::get('api/portfolio/positions', function(Request $request)
{
    $portfolio = Portfolio::find($request->id);

});



Route::get('/api/instrument/history', function($id) 
{

});



