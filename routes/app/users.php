<?php

Route::prefix('users')->group(function() {

    Route::get('edit', [
        'as' => 'users.edit',
        'uses' => 'UserController@edit'
    ]);

    Route::put('update', [
        'as' => 'users.update',
        'uses' => 'UserController@update'
    ]);

    Route::put('password', [
        'as' => 'users.password',
        'uses' => 'UserController@password'
    ]);

    Route::get('verify/{token}', [
        'as' => 'users.verify',
        'uses' => 'VerificationController@verifyEmail'
    ]);

});
