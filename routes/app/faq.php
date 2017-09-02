<?php

Route::middleware('auth')->group(function() {

    Route::get('/faq', [
        'as' => 'faq.index',
        'uses' => 'FaqController@index'
    ]);
});
