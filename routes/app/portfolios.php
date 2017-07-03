<?php

Route::resource('/portfolios', 'PortfoliosController');

Route::post('/portfolios/{portfolio}/deposit', [
    'as' => 'portfolio.deposit',
    'uses' => 'PortfoliosController@deposit'
]);

Route::post('/portfolios/{portfolio}/withdraw', [
    'as' => 'portfolio.withdraw',
    'uses' => 'PortfoliosController@withdraw'
]);
