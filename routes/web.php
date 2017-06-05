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


Route::get('/', 'HomeController@index');
Route::get('/blog', function() {});
Route::get('/about', function() {});

Auth::routes();

Route::resource('/portfolios', 'PortfoliosController');

// Position resources
Route::resource('/portfolios/{portfolio}/positions', 'PositionsController',
    ['except' => ['update', 'show']]);
Route::get('positions/buy/{position}', ['as' => 'positions.buy', 'uses' => 'PositionsController@buy']);
Route::get('positions/sell/{position}', ['as' => 'positions.sell', 'uses' => 'PositionsController@sell']);
Route::put('positions/update/{position}', ['as' => 'positions.update', 'uses' => 'PositionsController@update']);
Route::get('positions/{position}', ['as' => 'positions.show', 'uses' => 'PositionsController@show']);

// Search resources
Route::get('portfolios/{portfolio}/search/index', ['as' => 'search.index', 'uses' => 'SearchController@index']);
Route::get('portfolios/{portfolio}/search/{symbol}', ['as' => 'search.item', 'uses' => 'SearchController@item']);
Route::get('portfolios/{portfolio}/search/{type}/{id}', ['as' => 'search.show', 'uses' => 'SearchController@show']);

// Transaction resources
Route::get('transactions/index/{portfolio}', ['as' => 'transactions.index', 'uses' => 'TransactionController@index']);
Route::get('transactions/create/{portfolio}', ['as' => 'transactions.create', 'uses' => 'TransactionController@create']);
Route::get('transactions/{transaction}', ['as' => 'transactions.show', 'uses' => 'TransactionController@show']);


// Risk resources
Route::get('/portfolios/{portfolio}/risk', ['as' => 'risks.index', 'uses' => 'RiskController@index']);

// File upload
Route::post('/{portfolio}/image-upload', ['as' => 'image.upload', 'uses' => 'PortfoliosController@addImage']);

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