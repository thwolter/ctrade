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
            'exchange' => 'required|integer'
        ]);

        $stock = Stock::find($attributes['id']);
        $exchanges = $stock->exchangesToArray();

        $exchange = array_get($exchanges, $attributes['exchange'].'.code');
        $repo = new DataRepository($stock->datasources()->whereExchange($exchange)->first());

        return [
            'exchanges' => $exchanges,
            'stocks' => $repo->allDataHistory($attributes),
        ];
    }
}
