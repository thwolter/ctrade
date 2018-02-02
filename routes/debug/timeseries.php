<?php


use App\Classes\TimeSeries;

Route::get('/timeseries', function() {

    $data = [
        ['2017-12-29', null, 70, 60, 70],
        ['2017-12-28', null, 69, 60, 65],
        ['2017-12-27', null, 68, 60, 68],
        ['2017-12-23', null, 67, 60, 63],
        ['2017-12-22', null, 66, 60, 60],
    ];

    $columns = [
        'Date',
        'Open',
        'High',
        'Low',
        'Close'
    ];

    $timeseries = new TimeSeries($data, $columns);

    return $timeseries->asAssocArray()->getClose();
});

