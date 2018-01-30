<?php

namespace App\Http\ViewComposers;

use App\Services\StockService;
use Illuminate\View\View;

class StockMetricComposer {

    protected $service;


    public function __construct(StockService $service)
    {
        $this->service = $service;
    }


    public function compose(View $view)
    {
        $view->with('metrics', $this->service);
    }
}