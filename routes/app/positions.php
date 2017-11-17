<?php

// Position resources

Route::middleware('auth')->group(function() {

    Route::get('/{portfolio}/positions/index', [
        'as' => 'positions.index',
        'uses' => 'PositionsController@index'
    ]);

    Route::get('/{portfolio}/positions/search', [
        'as' => 'positions.search',
        'uses' => 'PositionsController@search'
    ]);

    Route::get('/{portfolio}/positions/{entity}/{slug}', [
        'as' => 'positions.show',
        'uses' => 'PositionsController@show'
    ]);

    Route::post('/positions/store', [
        'as' => 'positions.store',
        'uses' => 'PositionsController@store'
    ]);
});