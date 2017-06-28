<?php

Auth::routes();

Route::get('/verifyemail/{token}', [
    'as' => 'register.verify',
    'uses' =>'Auth\RegisterController@verify'
]);

Route::get('/register/success', [
    'as' => 'register.success',
    'uses' =>'Auth\RegisterController@success'
]);