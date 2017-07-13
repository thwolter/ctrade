<?php

namespace App\Http\Controllers;

use App\Entities\Stock;
use App\Http\Requests\SearchRequest;
use Illuminate\Http\Request;
use App\Entities\Portfolio;

class ApiController extends Controller
{

    /**
     * Receive search results from entities.
     *
     * @param SearchRequest $request
     * @return string
     */
    public function search(SearchRequest $request)
    {
        return json_encode(Stock::search($request->get('query'))->get());
    }


    /**
     * receive metadata and price history for an stock with given id.
     *
     * @param Request $request
     * @return string
     */
    public function lookup(Request $request)
    {
        $stock = Stock::find($request->id);

        $prices = [
            ['exchange' => 'Stuttgart', 'price' => $stock->price()],
            // define further exchanges
        ];

        return json_encode([
            'item' => $stock->toReadableArray(),
            'prices' => $prices,
            'history' => $stock->history()
        ]);
    }


    /**
     * Returns the positions list with price, total and share for portfolio with given id.
     *
     * @param Request $request
     * @return string
     */
    public function positions(Request $request)
    {
        $portfolio = Portfolio::find($request->get('id'));

        $items = [];
        foreach ($portfolio->positions as $position) {
            $price = $position->price();
            $array = $position->toArray();

            $items[] = array_merge($array, [
                'price' => head($price),
                'total' => head($price) * $array['amount'],
                'date' => key($price),
                'currency' => $position->currencyCode()
            ]);
        }

        $collection = collect($items)->sortByDesc('total');
        $total = $collection->sum('total');

        $positions = $collection->toArray();

        foreach ($positions as &$record) {
            $record['share'] = $record['total']/$total;
        }

        return collect(['positions' => $positions, 'total' => $total]);
    }
}
