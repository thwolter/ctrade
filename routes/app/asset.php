<?php

//Route::resource('/portfolios', 'PortfoliosController');

Route::prefix('asset')->middleware('auth')->group(function() {

    Route::post('store', [
        'as' => 'asset.store',
        'uses' => 'AssetController@store'
    ]);

    Route::get('', [
        'as' => 'asset.index',
        'uses' => 'AssetController@index'
    ]);

    Route::put('{portfolio}/update', [
        'as' => 'asset.update',
        'uses' => 'AssetController@update'
    ]);

    Route::get('{portfolio}', [
        'as' => 'asset.show',
        'uses' => 'AssetController@show'
    ]);

    Route::delete('{slug}/delete', [
        'as' => 'asset.destroy',
        'uses' => 'AssetController@destroy'
    ]);

    Route::get('{portfolio}/edit', [
        'as' => 'asset.edit',
        'uses' => 'AssetController@edit'
    ]);

});





