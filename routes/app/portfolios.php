<?php

Route::resource('/portfolios', 'PortfoliosController');

Route::post('/portfolios/{portfolio}/deposit', [
    'as' => 'portfolios.deposit',
    'uses' => 'PortfoliosController@deposit'
]);

Route::post('/portfolios/{portfolio}/withdraw', [
    'as' => 'portfolios.withdraw',
    'uses' => 'PortfoliosController@withdraw'
]);
