<?php

Route::middleware('auth')->group(function () {

    Route::get('/{portfolio}/limits', [
        'as' => 'limits.index',
        'uses' => 'LimitController@index'
    ]);

    Route::get('/{portfolio}/limits/create', [
        'as' => 'limits.create',
        'uses' => 'LimitController@create'
    ]);

    Route::post('/limits', [
        'as' => 'limits.set',
        'uses' => 'LimitController@set'
    ]);

    Route::post('/limits/store', [
        'as' => 'limits.store',
        'uses' => 'LimitController@store'
    ]);

});
