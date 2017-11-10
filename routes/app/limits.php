<?php

Route::middleware('auth')->group(function () {

    Route::post('/limits', [
        'as' => 'limits.set',
        'uses' => 'LimitController@set'
    ]);

    Route::post('/limits/store', [
        'as' => 'limits.store',
        'uses' => 'LimitController@store'
    ]);

});
