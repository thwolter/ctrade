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

/*Route::get('/user', function() {

    return dd(auth()->id());

});*/


// User auth
Auth::routes();
Route::get('/home', 'HomeController@index');
