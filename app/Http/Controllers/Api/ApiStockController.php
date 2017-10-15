<?php

namespace App\Http\Controllers\Api;

use App\Entities\Datasource;
use App\Entities\Stock;
use App\Facades\DataService;
use App\Http\Resources\StockHistory;
use Illuminate\Http\Request;

class ApiStockController extends ApiBaseController
{


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

        $repo = new DataService($stock->datasources()->whereExchange($exchange)->first());

        return [
            'exchanges' => $exchanges,
            'history' => array_add($repo->allDataHistory($attributes), 'currency', 'EUR')
        ];
    }
}
