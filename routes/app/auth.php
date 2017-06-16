<?php

Auth::routes();

Route::get('/verifyemail/{token}', ['as' => 'register.verify', 'uses' =>'Auth\RegisterController@verify']);