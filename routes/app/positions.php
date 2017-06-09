<?php

// Position resources
Route::resource('/portfolios/{portfolio}/positions', 'PositionsController',
    ['except' => ['update', 'show']]);
Route::get('positions/buy/{position}', ['as' => 'positions.buy', 'uses' => 'PositionsController@buy']);
Route::get('positions/sell/{position}', ['as' => 'positions.sell', 'uses' => 'PositionsController@sell']);
Route::put('positions/update/{position}', ['as' => 'positions.update', 'uses' => 'PositionsController@update']);
Route::get('positions/{position}', ['as' => 'positions.show', 'uses' => 'PositionsController@show']);
