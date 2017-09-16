<?php

// Transaction resources
Route::group(['middleware' => 'auth'], function() {

    Route::get('{portfolio}/transactions/index', [
        'as' => 'transactions.index',
        'uses' => 'PaymentController@index'
    ]);

});

