<?php

// Asset resources

Route::middleware('auth')->group(function() {


    Route::get('/{portfolio}/assets/{asset}', [
        'as' => 'assets.show',
        'uses' => 'AssetController@show'
    ]);

});