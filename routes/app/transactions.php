<?php

// Transaction resources
Route::group(['middleware' => 'auth'], function() {

    Route::get('{portfolio}/transactions/index', [
        'as' => 'transactions.index',
        'uses' => 'TransactionController@index'
    ]);

    Route::get('transactions/{transaction}', [
        'as' => 'transactions.show',
        'uses' => 'TransactionController@show'
    ]);

});

