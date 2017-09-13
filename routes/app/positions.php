<?php

// Position resources

Route::middleware('auth')->group(function() {

    Route::resource('/positions', 'PositionsController',
        ['only' => ['store', 'destroy']]);


    Route::get('/{slug}/positions/index', [
        'as' => 'positions.index',
        'uses' => 'PositionsController@index'
    ]);

    Route::get('/{slug}/positions/{entity}/{instrumentSlug}', [
        'as' => 'positions.create',
        'uses' => 'PositionsController@create'
    ]);

    Route::get('/{slug}/buy/{assetSlug}', [
        'as' => 'positions.buyStock',
        'uses' => 'PositionsController@buyStock'
    ]);

    Route::get('/{slug}/sell/{assetSlug}', [
        'as' => 'positions.sellStock',
        'uses' => 'PositionsController@sellStock'
    ]);



});