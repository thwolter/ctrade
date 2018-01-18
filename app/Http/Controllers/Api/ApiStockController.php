<?php

namespace App\Http\Controllers\Api;

use App\Entities\Stock;
use App\Services\DataService;
use App\Services\MetricServices\StockMetricService;
use Illuminate\Http\Request;

class ApiStockController extends ApiBaseController
{

    protected $metrics;


    public function __construct(StockMetricService $metrics)
    {
        $this->metrics = $metrics;
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

        //todo: should use asAssociativeArray or toArray
        $exchanges = $stock->exchangesToArray();

        return [
            'exchanges' => $exchanges,
            'data' => $this->metrics->dataHistory($stock, $stock->firstExchange())
        ];
    }
}
