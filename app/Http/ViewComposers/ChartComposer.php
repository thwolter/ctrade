<?php

namespace App\Http\ViewComposers;

use App\Services\ChartService;
use Illuminate\View\View;

class ChartComposer {

    protected $chartService;


    public function __construct(ChartService $chartService)
    {
        $this->chartService = $chartService;
    }


    public function compose(View $view)
    {
        $view->with('chart', $this->chartService);
    }
}