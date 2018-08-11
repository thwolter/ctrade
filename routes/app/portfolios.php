<?php

Route::prefix('')->middleware('auth')->group(function() {

    Route::get('', [
        'as' => 'portfolios.index',
        'uses' => 'PortfoliosController@index'
    ]);

    Route::get('create', [
        'as' => 'portfolios.create',
        'uses' => 'PortfoliosController@create'
    ]);

    Route::get('{portfolio}/created', [
        'as' => 'portfolios.fresh',
        'uses' => 'PortfoliosController@fresh'
    ]);

    Route::put('{portfolio}/update', [
        'as' => 'portfolios.update',
        'uses' => 'PortfoliosController@update'
    ]);


    Route::get('{portfolio}', [
        'as' => 'portfolios.show',
        'uses' => 'PortfoliosController@show'
    ]);

    Route::delete('{slug}/delete', [
        'as' => 'portfolios.destroy',
        'uses' => 'PortfoliosController@destroy'
    ]);

    Route::get('{portfolio}/edit', [
        'as' => 'portfolios.edit',
        'uses' => 'PortfoliosController@edit'
    ]);

});





