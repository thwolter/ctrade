<?php

//Route::auth();
//Route::get('logout', 'Auth\LoginController@logout');

CRUD::resource('exchange', 'ExchangeCrudController');
CRUD::resource('alias', 'AliasCrudController');
CRUD::resource('stocks', 'StockCrudController');




