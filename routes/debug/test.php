<?php


Route::get('test', function() {

    $crypto = new \App\Classes\DataProvider\CryptoCompare();

    echo $crypto->getBaseImageUrl('ETH');

    dd($crypto->filterCoindata('Eth'));

});

