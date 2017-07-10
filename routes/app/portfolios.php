<?php

Route::resource('/portfolios', 'PortfoliosController');

Route::post('/portfolios/pay', [
    'as' => 'portfolios.pay',
    'uses' => 'PortfoliosController@pay'
]);

