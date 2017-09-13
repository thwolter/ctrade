<?php

// Asset resources

Route::middleware('auth')->group(function() {

    Route::get('/{slug}/positions/{assetSlug}/{transaction}', [
        'as' => 'assets.tradeStock',
        'uses' => 'AssetController@tradeStock'
    ]);

});