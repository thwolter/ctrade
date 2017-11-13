<?php

// Transaction resources
Route::group(['middleware' => 'auth'], function() {

    Route::get('{portfolio}/transactions/index', [
        'as' => 'payments.index',
        'uses' => 'PaymentController@index'
    ]);

    Route::get('{portfolio}/payment', [
        'as' => 'payments.create',
        'uses' => 'PaymentController@create'
    ]);

    Route::post('{portfolio}/payment/store', [
        'as' => 'payments.store',
        'uses' => 'PaymentController@store'
    ]);

});

