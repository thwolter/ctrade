<?php

namespace App\Http\Controllers\Api;

use App\Entities\Stock;
use App\Services\DataService;
use Illuminate\Http\Request;

class ApiStockController extends ApiBaseController
{

    protected $dataService;


    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }


    public function history(Request $request)
    {
        $attributes = $request->validate([
            'id' => 'required|exists:stocks,id',
            'date' => 'sometimes|date|nullable',
            'count' => 'required_with:date|integer',
            'from' => 'empty_with:date|date',
            'to' => 'required_with:from|date',
            'exchange' => 'sometimes|nullable'
        ]);

        $stock = Stock::find($attributes['id']);
        $exchanges = $stock->exchangesToArray();

        $exchange = array_get($attributes, 'exchange', array_get($exchanges, '0.code'));

        return [
            'exchanges' => $exchanges,
            'data' => $this->dataService->dataHistory($stock->getDatasource($exchange))
        ];
    }
}
