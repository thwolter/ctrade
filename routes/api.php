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


Route::get('/error', 'Api\ApiBaseController@apiCallError');

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
Route::get('/search', 'Api\ApiSearchController@search');
Route::get('/lookup', 'Api\ApiSearchController@lookup');


/*
|--------------------------------------------------------------------------
| API Database Routes
|--------------------------------------------------------------------------
|
| This routes provide information to the specified portfolio, like positions
| to receive the contribution of all positions in a portfolios. valueHistory
| provides the historic values of the portfolio.
|
*/
Route::group(['middleware' => ['auth:api']], function() {
    Route::get('/portfolio/positions', 'Api\ApiDatabaseController@positions');
    Route::get('/portfolio/value', 'Api\ApiDatabaseController@value');
    Route::get('/portfolio/risk', 'Api\ApiDatabaseController@risk');
    Route::get('/portfolio/limits', 'Api\ApiDatabaseController@limits');
    Route::get('/portfolio/utilisation', 'Api\ApiDatabaseController@utilisation');
    Route::get('/portfolio/contribution', 'Api\ApiDatabaseController@contribution');
    Route::get('/portfolio/graph', 'Api\ApiDatabaseController@graph');
});

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
Route::group(['middleware' => ['client']], function() {
    Route::get('/portfolio/calc/value', 'Api\ApiCalculationController@portfolioCalculateValue');
    Route::get('/portfolio/calc/risk', 'Api\ApiCalculationController@portfolioCalculateRisk');
});



/*
|--------------------------------------------------------------------------
| API Raw Data Routes
|--------------------------------------------------------------------------
|
| This routes enable R scripts to receive data on portfolio and market data
| histories and are called directly from within the R scripts.
|
*/
Route::get('/histories', 'Api\ApiDataController@histories');
Route::get('/portfolio', 'Api\ApiDataController@portfolio');


/*
|--------------------------------------------------------------------------
| API Notification routes
|--------------------------------------------------------------------------
|
|
*/
Route::post('/notifications/read', 'Api\ApiNotificationsController@markAsRead');

/*
|--------------------------------------------------------------------------
| For test purpose only
|--------------------------------------------------------------------------
|
| This routes can be used for debugging as it allows to set break points.
|
*/
