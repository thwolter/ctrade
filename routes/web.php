<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\User;
use App\Portfolio;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/blog', function() {

});

Route::get('/about', function() {

});


Route::resource('/portfolios', 'PortfoliosController');


/*
 * Positions resources
 */
Route::resource('/portfolios/{portfolio}/positions', 'PositionsController',
    ['except' => ['edit', 'update', 'show', 'destroy']]);
    

Route::get('positions/{position}', ['as' => 'positions.show', 'uses' => 'PositionsController@show']);
Route::delete('positions/{position}', ['as' => 'positions.destroy', 'uses' => 'PositionsController@destroy']);

/*
 * Search resources
 */
Route::get('portfolios/{portfolio}/positions/index', ['as' => 'search.index', 'uses' => 'SearchController@index']);
Route::get('portfolios/{portfolio}/positions/item', ['as' => 'search.show', 'uses' => 'SearchController@show']);
Route::get('portfolios/{portfolio}/positions/show', ['as' => 'search.show', 'uses' => 'SearchController@create']);

// User auth
Auth::routes();
Route::get('/home', 'HomeController@index');

