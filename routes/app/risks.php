<?php

// Risk resources
Route::get('/portfolios/{portfolio}/risk', ['as' => 'risks.index', 'uses' => 'RiskController@index']);
