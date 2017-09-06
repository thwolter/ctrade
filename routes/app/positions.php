<?php

// Position resources

Route::middleware('auth')->group(function() {

    Route::resource('/positions', 'PositionsController',
        ['only' => ['store', 'destroy']]);

    Route::post('/positions/fetch', [
        'as' => 'positions.fetch',
        'uses' => 'PositionsController@fetch'
    ]);

    Route::match(['put', 'patch'], '/positions/update', [
        'as' => 'positions.update',
        'uses' => 'PositionsController@update'
    ]);

    Route::get('/{slug}/positions/index', [
        'as' => 'positions.index',
        'uses' => 'PositionsController@index'
    ]);

    Route::get('/{slug}/positions/{position}', [
        'as' => 'positions.show',
        'uses' => 'PositionsController@show'
    ]);
});