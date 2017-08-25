<?php

//Route::resource('/portfolios', 'PortfoliosController');

Route::prefix('portfolio')->group(function() {

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

    Route::put('{slug}/update', [
        'as' => 'portfolios.update',
        'uses' => 'PortfoliosController@update'
    ]);


    Route::get('{slug}', [
        'as' => 'portfolios.show',
        'uses' => 'PortfoliosController@show'
    ]);

    Route::delete('{slug}/delete', [
        'as' => 'portfolios.destroy',
        'uses' => 'PortfoliosController@destroy'
    ]);

    Route::get('{slug}/edit', [
        'as' => 'portfolios.edit',
        'uses' => 'PortfoliosController@edit'
    ]);

});





