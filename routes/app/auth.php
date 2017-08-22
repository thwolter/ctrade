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

Route::get('/{provider}/callback', [
    'as' => 'social.callback',
    'uses' => 'Auth\SocialAuthController@callback'
]);


Route::group(['middleware' => 'web', 'prefix' => config('backpack.base.route_prefix')], function () {
    Route::get('login', 'Admin\LoginController@showLoginForm');
    Route::get('register', 'Auth\RegisterController@showRegistrationForm');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    Route::get('logout', 'Auth\LoginController@logout');
});

