<?php

// Transaction resources
Route::get('transactions/index/{portfolio}', ['as' => 'transactions.index', 'uses' => 'TransactionController@index']);
Route::get('transactions/create/{portfolio}', ['as' => 'transactions.create', 'uses' => 'TransactionController@create']);
Route::get('transactions/{transaction}', ['as' => 'transactions.show', 'uses' => 'TransactionController@show']);
