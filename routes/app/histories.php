<?php

// History resources
Route::get('/history/{portfolio}', ['as' => 'history.index', 'uses' => 'HistoryController@index']);
