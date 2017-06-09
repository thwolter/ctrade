<?php

// File upload
Route::post('/{portfolio}/image-upload', ['as' => 'image.upload', 'uses' => 'PortfoliosController@addImage']);
