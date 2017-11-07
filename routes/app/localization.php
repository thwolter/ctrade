<?php

// Localization
Route::get('/js/lang.js', [
    'as' => 'resources.lang',
    'uses' => 'LocalizationController@getStrings'
]);
