<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| API Search Routes
|--------------------------------------------------------------------------
|
| This routes provide access to the metadata search. Metadata as stored in
| in the database are searched to find a specified instrument, e.g. stock.
| The lookup route delivers the parameter to a specified instrument.
|
*/
Route::get('/search', 'ApiController@search');
Route::get('/lookup', 'ApiController@lookup');


/*
|--------------------------------------------------------------------------
| API Portfolio Routes
|--------------------------------------------------------------------------
|
| This routes provide information to the specified portfolio, like positions
| to receive the contribution of all positions in a portfolios. valueHistory
| provides the historic values of the portfolio.
|
*/
Route::get('/portfolio/positions', 'ApiController@positions');
Route::get('/portfolio/value', 'ApiController@portfolioValue');
Route::get('/portfolio/risk', 'ApiController@portfolioRisk');

/*
|--------------------------------------------------------------------------
| API Calculation Routes
|--------------------------------------------------------------------------
|
| This routes provide information to the specified portfolio, like positions
| to receive the contribution of all positions in a portfolios. valueHistory
| provides the historic values of the portfolio.
|
*/
Route::get('/portfolio/calc/value', 'ApiController@portfolioCalculateValue');
Route::get('/portfolio/calc/risk', 'ApiController@portfolioCalculateRisk');
Route::get('/summary', 'ApiController@summary');

/*
|--------------------------------------------------------------------------
| API Raw Data Routes (typically used for R scripts)
|--------------------------------------------------------------------------
|
| This routes enable R scripts to receive data on portfolio and market data
| histories and are called directly from within the R scripts.
|
*/
Route::get('/histories', 'ApiController@histories');
Route::get('/portfolio', 'ApiController@portfolio');



Route::get('/test', function() {
    Artisan::call('calculate:value');
});