<?php


Route::get('test', function() {

    $crypto = new \App\Classes\DataProvider\CryptoCompare();

    echo $crypto->getBaseImageUrl('ETH');

    dd($crypto->filterCoinData('Eth'));

});


Route::get('php', function() {
    $a = 1;
    echo phpversion();
});
