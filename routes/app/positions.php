<?php

// Position resources

Route::middleware('auth')->group(function() {

    Route::post('/positions', [
        'as' => 'positions.store',
        'uses' => 'PositionsController@store'
    ]);

    Route::get('/{portfolio}/positions/index', [
        'as' => 'positions.index',
        'uses' => 'PositionsController@index'
    ]);

    Route::get('/{portfolio}/positions/{entity}/{instrument}/create', [
        'as' => 'positions.create',
        'uses' => 'PositionsController@create'
    ]);

    Route::get('/{portfolio}/positions/{stock}/{transaction}', [
        'as' => 'positions.tradeStock',
        'uses' => 'PositionsController@tradeStock'
    ]);

    Route::get('/{portfolio}/positions/stock', [
        'as' => 'positions.createStock',
        'uses' => 'PositionsController@createStock'
    ]);


});