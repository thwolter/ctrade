<?php


use App\Facades\CurrencyService;

Route::get('/ccypair', function() {

    return CurrencyService::priceAt('EUR', 'USD', '2017-12-27');
});

