<?php

Route::get('/', 'HomeController@index');
Route::get('/contact', ['as' => 'home.contact', 'uses' => 'HomeController@contact']);
Route::get('/about', ['as' => 'home.about', 'uses' => 'HomeController@about']);
Route::get('/blog', ['as' => 'home.blog', 'uses' => 'HomeController@blog']);
Route::get('/coming', ['as' => 'home.coming', 'uses' => 'HomeController@coming']);
Route::get('/legal', ['as' => 'home.legal', 'uses' => 'HomeController@legal']);

