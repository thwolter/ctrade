<?php

// Asset resources

Route::middleware('auth')->group(function() {


    Route::get('/{slug}/assets/{$assetSlug}', [
        'as' => 'assets.show',
        'uses' => 'AssetController@show'
    ]);

});