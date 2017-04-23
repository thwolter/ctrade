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
Route::resource('/portfolios/{portfolio}/positions', 'PositionsController');


// Search resources
Route::get('portfolios/{portfolio}/search/index', ['as' => 'search.index', 'uses' => 'SearchController@index']);
Route::get('portfolios/{portfolio}/search/{symbol}', ['as' => 'search.item', 'uses' => 'SearchController@item']);
Route::get('portfolios/{portfolio}/search/{type}/{symbol}', ['as' => 'search.show', 'uses' => 'SearchController@show']);

// User auth
Auth::routes();
Route::get('/home', 'HomeController@index');


Route::get('phpinfo', function() {
    phpinfo();
});

App::bind(
    'App\Repositories\Contracts\InstrumentInterface',
    'App\Repositories\InstrumentRepository'
);

Route::get('chart/{id}', function($id) {
    $portfolio = \App\Entities\Portfolio::find($id);
    \App\Models\Charts::LineChart();
    \App\Models\Charts::gaugeChart();
    return view('test');
});