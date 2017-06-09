<?php

Route::get('/', 'HomeController@index');
Route::get('/blog', function() {});
Route::get('/about', function() {});

Route::get('test', function() {
    return view('test');
});