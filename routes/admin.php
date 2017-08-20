<?php

//Route::get('login', 'AuthController@login');
//Route::get('logout', 'AuthController@logout@logout');

CRUD::resource('exchange', 'ExchangeCrudController');
CRUD::resource('alias', 'AliasCrudController');




