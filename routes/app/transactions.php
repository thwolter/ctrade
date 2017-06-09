<?php

// Transaction resources
Route::get('transactions/{portfolio}/index', [
    'as' => 'transactions.index',
    'uses' => 'TransactionController@index'
]);

Route::get('transactions/{portfolio}/create', [
    'as' => 'transactions.create',
    'uses' => 'TransactionController@create'
]);

Route::get('transactions/{portfolio}/{transaction}', [
    'as' => 'transactions.show',
    'uses' => 'TransactionController@show'
]);
