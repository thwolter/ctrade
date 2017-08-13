<?php

//Route::resource('/portfolios', 'PortfoliosController');

Route::prefix('portfolios')->group(function() {

    Route::post('store', [
        'as' => 'portfolios.store',
        'uses' => 'PortfoliosController@store'
    ]);

    Route::get('', [
        'as' => 'portfolios.index',
        'uses' => 'PortfoliosController@index'
    ]);

    Route::get('create', [
        'as' => 'portfolios.create',
        'uses' => 'PortfoliosController@create'
    ]);

    Route::post('pay', [
        'as' => 'portfolios.pay',
        'uses' => 'PortfoliosController@pay'
    ]);

    Route::put('update/{id}', [
        'as' => 'portfolios.update',
        'uses' => 'PortfoliosController@update'
    ]);

    Route::get('show/{id}', [
        'as' => 'portfolios.show',
        'uses' => 'PortfoliosController@show'
    ]);

    Route::delete('delete/{id}', [
        'as' => 'portfolios.destroy',
        'uses' => 'PortfoliosController@destroy'
    ]);

    Route::get('edit/{id}', [
        'as' => 'portfolios.edit',
        'uses' => 'PortfoliosController@edit'
    ]);

});




