<?php

Route::post('/', [
    'as' => 'home',
    'uses' => 'HomeController@index'
]);
