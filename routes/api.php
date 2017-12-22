<?php


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
| API Portfolio Routes
|--------------------------------------------------------------------------
|
| This routes provide information to the specified portfolio, like positions
| to receive the contribution of all positions in a portfolios. valueHistory
| provides the historic values of the portfolio.
|
*/
//Route::group(['middleware' => ['auth:api']], function() {
    Route::get('/portfolio/assets', 'Api\ApiPortfolioController@assets');
    Route::get('/portfolio/value', 'Api\ApiPortfolioController@value');
    Route::get('/portfolio/risk', 'Api\ApiPortfolioController@risk');
    Route::get('/portfolio/limits', 'Api\ApiPortfolioController@limits');
    Route::get('/portfolio/utilisation', 'Api\ApiPortfolioController@utilisation');
    Route::get('/portfolio/contribution', 'Api\ApiPortfolioController@contribution');
    Route::get('/portfolio/keyFigures', 'Api\ApiPortfolioController@keyFigures');
//});


/*
|--------------------------------------------------------------------------
| API Position Routes
|--------------------------------------------------------------------------
|
| This routes provide information to the specified portfolio, like positions
| to receive the contribution of all positions in a portfolios. valueHistory
| provides the historic values of the portfolio.
|
*/

Route::group(['middleware' => ['auth:api']], function() {
    Route::post('/asset/fetch', 'Api\ApiAssetController@fetch');
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
| API Notification Routes
|--------------------------------------------------------------------------
|
|
*/
Route::post('/notifications/read', 'Api\ApiNotificationsController@markAsRead');


/*
|--------------------------------------------------------------------------
| API Stock Routes
|--------------------------------------------------------------------------
|
|
*/

Route::get('/stock/history', 'Api\ApiStockController@history');

/*
|--------------------------------------------------------------------------
| For test purpose only
|--------------------------------------------------------------------------
|
| This routes can be used for debugging as it allows to set break points.
|
*/
