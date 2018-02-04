<?php


use App\Entities\CcyPair;
use App\Entities\Stock;
use App\Facades\DataService;

Route::get('/ccypair', function() {

    $ccyPair = CcyPair::find(1)->first();
    $price = DataService::price($ccyPair);

    return CcyPair::first(1)->exchangesToArray();
});

