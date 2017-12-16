<?php

namespace App\Http\ViewComposers;

use App\Services\ChartService;
use App\Services\DataService;
use Illuminate\View\View;

class ShowPositionComposer {

    protected $dataService;


    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }


    public function compose(View $view)
    {
        $view->with('priceData', $this->dataService);
    }
}