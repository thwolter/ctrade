<?php

Route::prefix('user')->middleware('auth')->group(function() {

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


    Route::get('email/link', [
        'as' => 'users.emailLink',
        'uses' => 'UserController@emailLink'
    ]);

    Route::get('email/cancel', [
        'as' => 'users.emailCancel',
        'uses' => 'UserController@emailCancel'
    ]);

});

Route::get('user/verify/{token}', [
    'as' => 'users.verify',
    'uses' => 'VerificationController@verifyEmail'
]);
