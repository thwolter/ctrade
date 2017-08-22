<?php

//Route::resource('/portfolios', 'PortfoliosController');


    Route::post('portfolio/store', [
        'as' => 'portfolios.store',
        'uses' => 'PortfoliosController@store'
    ]);

    Route::get('portfolio/', [
        'as' => 'portfolios.index',
        'uses' => 'PortfoliosController@index'
    ]);

    Route::get('portfolio/create', [
        'as' => 'portfolios.create',
        'uses' => 'PortfoliosController@create'
    ]);

    Route::post('portfolio/pay', [
        'as' => 'portfolios.pay',
        'uses' => 'PortfoliosController@pay'
    ]);

    Route::put('{slug}/update', [
        'as' => 'portfolios.update',
        'uses' => 'PortfoliosController@update'
    ]);

    Route::get('{slug}/show', [
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






