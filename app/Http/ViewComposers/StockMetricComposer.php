<?php

namespace App\Http\ViewComposers;

use App\Services\MetricServices\StockMetricService;
use Illuminate\View\View;

class StockMetricComposer {

    protected $service;


    public function __construct(StockMetricService $service)
    {
        $this->service = $service;
    }


    public function compose(View $view)
    {
        $view->with('metrics', $this->service);
    }
}