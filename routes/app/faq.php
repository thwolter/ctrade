<?php

Route::get('/faq', [
    'as' => 'faq.index',
    'uses' => 'FaqController@index'
]);
