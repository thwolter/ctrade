<?php

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::get('/contact', ['as' => 'home.contact', 'uses' => 'HomeController@contact']);
Route::get('/about', ['as' => 'home.about', 'uses' => 'HomeController@about']);
Route::get('/coming', ['as' => 'home.coming', 'uses' => 'HomeController@coming']);
Route::get('/legal', ['as' => 'home.legal', 'uses' => 'HomeController@legal']);
Route::get('/privacy', ['as' => 'home.privacy', 'uses' => 'HomeController@privacy']);
Route::get('/policy', ['as' => 'home.policy', 'uses' => 'HomeController@policy']);

Route::get('/launch', ['as' => 'home.launch', 'uses' => 'HomeController@launch']);

Route::post('/subscribe', ['as' => 'taker.subscribe', 'uses' => 'TakerController@subscribe']);
Route::get('/verify/{token}', ['as' => 'taker.verify', 'uses' => 'TakerController@verify']);

