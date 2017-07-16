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
 * Search requests
 */
Route::get('/search', 'ApiController@search');
Route::get('/lookup', 'ApiController@lookup');

Route::get('/positions', 'ApiController@positions');

Route::get('/summary', 'ApiController@summary');
Route::get('/histories', 'ApiController@histories');
Route::get('/portfolio', 'ApiController@portfolio');

Route::get('/portfolio/risk', 'ApiController@portfolioRisk');

//Route::get('/test', Artisan::call('calculate:risk'));