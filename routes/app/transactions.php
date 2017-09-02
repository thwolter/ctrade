<?php

// Transaction resources
Route::group(['middleware' => 'auth'], function() {

    Route::get('{slug}/transactions/index', [
        'as' => 'transactions.index',
        'uses' => 'TransactionController@index'
    ]);

    Route::get('{slug}/transactions/create', [
        'as' => 'transactions.create',
        'uses' => 'TransactionController@create'
    ]);

    Route::get('transactions/{transaction}', [
        'as' => 'transactions.show',
        'uses' => 'TransactionController@show'
    ]);

});

