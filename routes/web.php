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


/*Route::get('portfolios', 'PortfoliosController@index');
Route::get('portfolios/{id}', 'PortfoliosController@show');
*/


/*Route::get('create', function() {

    $user = User::findorfail(1);
    $portfolio = new Portfolio(['name'=>'My Portfolio', 'currency'=>'EUR']);
    $user->portfolios()->save($portfolio);

});*/

/*Route::get('portfolio/create/stock{symbol}', function($symbol) {

    $user = User::findOrFail(1);
    $portfolio = User::portfolios(1);
    $stock = new App\Stock(['symbol'=>$symbol, 'currency'=>'EUR']);


});*/


Route::resource('/portfolios', 'PortfoliosController');
Route::get('/user', function() {

    return dd(auth()->id());

});


// User auth
Auth::routes();
Route::get('/home', 'HomeController@index');
