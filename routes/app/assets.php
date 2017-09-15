<?php

// Asset resources

Route::middleware('auth')->group(function() {


    Route::get('/{portfolio}/assets/{slug}', [
        'as' => 'assets.show',
        'uses' => 'AssetController@show'
    ]);

});