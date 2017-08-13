<?php

Route::post('/limits', [
    'as' => 'limits.set',
    'uses' => 'LimitController@set'
]);
