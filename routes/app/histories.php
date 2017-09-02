<?php

// History resources
Route::middleware('auth')->group(function() {

    Route::get('/history/{portfolio}', [
        'as' => 'history.index',
        'uses' => 'HistoryController@index'
    ]);
});
