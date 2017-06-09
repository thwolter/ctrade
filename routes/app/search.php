<?php

// Search resources
Route::get('portfolios/{portfolio}/search/index', ['as' => 'search.index', 'uses' => 'SearchController@index']);
Route::get('portfolios/{portfolio}/search/{symbol}', ['as' => 'search.item', 'uses' => 'SearchController@item']);
Route::get('portfolios/{portfolio}/search/{type}/{id}', ['as' => 'search.show', 'uses' => 'SearchController@show']);
