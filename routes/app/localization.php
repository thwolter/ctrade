<?php

// Localization
Route::get('/js/lang-{locale}.js', [
    'as' => 'resources.lang',
    'uses' => 'LocalizationController@getStrings'
]);
