<?php


Route::get('portfolios/{portfolio}/search', [
    'as' => 'search.show',
    'uses' => 'SearchController@show'
]);

Route::post('search/stock', [
    'as' => 'search.stock',
    'uses' => 'SearchController@searchStock'
]);