<?php


use App\Facades\RiskService\RiskService;


Route::get('/portfolioVaR', function() {
    echo RiskService::portfolioVaR(\App\Entities\Portfolio::find(1), [
        'confidence' => 0.95, 'period' => 1, 'date' => '2018-01-03', 'count' => 90
    ]);

    echo "\n";

    echo RiskService::assetVaR(Asset::find(1), [
        'confidence' => 0.95, 'period' => 1, 'date' => '2018-01-03', 'count' => 90
    ]);

    echo "\n";

    echo RiskService::instrumentVaR(Asset::find(1)->positionable, [
        'confidence' => 0.95, 'period' => 1, 'date' => '2018-01-03', 'count' => 90
    ]);
});


Route::get('calculate/risk', function() { Artisan::call('calculate:risk'); });
Route::get('calculate/value', function() { Artisan::call('calculate:value'); });


