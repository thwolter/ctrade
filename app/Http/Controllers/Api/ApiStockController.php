<?php

namespace App\Http\Controllers\Api;

use App\Entities\Datasource;
use App\Entities\Stock;
use App\Repositories\DataRepository;
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
            'exchange' => 'sometimes|string'
        ]);

        $stock = Stock::find($attributes['id']);
        $exchanges = $stock->exchangesAsAssociativeArray();

        $exchange = array_has($attributes, 'exchange') ? $attributes['exchange'] : key($exchanges);
        $datarepo = new DataRepository($stock->datasources()->whereExchange($exchange)->first());

        return [
            'exchanges' => $stock->exchangesAsAssociativeArray(),
            'stocks' => $datarepo->allDataHistory($attributes),
        ];
    }
}
