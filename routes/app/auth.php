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

Route::get('/social/{provider}/login', [
    'as' => 'social.login',
    'uses' => 'Auth\SocialAuthController@redirect'
]);

Route::get('/social/{provider}/callback', [
    'as' => 'social.callback',
    'uses' => 'Auth\SocialAuthController@callback'
]);

Route::put('users/password', [
    'as' => 'users.password',
    'uses' => 'UserController@password'
]);

