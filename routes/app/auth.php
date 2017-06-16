<?php

Auth::routes();

Route::get('/verifyemail/{token}', 'Auth\RegisterController@verify');