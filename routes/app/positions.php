<?php

// Position resources
Route::resource('/portfolios/{portfolio}/positions', 'PositionsController',
    ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

Route::post('/positions/fetch', [
    'as' => 'positions.fetch',
    'uses' => 'PositionsController@fetch'
]);