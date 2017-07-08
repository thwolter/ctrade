<?php

namespace App\Http\Controllers;

use App\Entities\Stock;
use App\Http\Requests\SearchRequest;
use Illuminate\Http\Request;
use App\Entities\Portfolio;

class SearchController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    protected $types = [
        'stock' => 'Aktie'
    ];

    protected $typesMap = [
        'stock' => Stock::class
    ];



    public function search(SearchRequest $request)
    {
        return json_encode(Stock::search($request->get('query'))->get());
    }


    public function lookup(Request $request)
    {
        $stock = Stock::find($request->id);

        $prices = [
            ['exchange' => 'Stuttgart', 'price' => $stock->price()],
            ['exchange' => 'FakeExchange', 'price' => $stock->price()]
        ];

        return json_encode([
            'item' => $stock->toReadableArray(),
            'prices' => $prices,
            'history' => $stock->history()
        ]);
    }
}
