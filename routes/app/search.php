<?php

Route::post('search/stock', [
    'as' => 'search.stock',
    'uses' => 'SearchController@search'
]);

Route::post('search/lookup', [
    'as' => 'search.lookup',
    'uses' => 'SearchController@lookup'
]);