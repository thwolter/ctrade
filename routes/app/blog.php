<?php

Route::middleware('auth')->group(function () {

    Route::get('/blog', [
        'as' => 'blog.index',
        'uses' => 'PostController@index'
    ]);

    Route::get('/blog/{post}', [
        'as' => 'blog.show',
        'uses' => 'PostController@show'
    ]);

});


