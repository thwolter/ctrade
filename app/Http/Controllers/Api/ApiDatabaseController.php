<?php

namespace App\Http\Controllers\Api;

use App\Entities\Portfolio;
use App\Repositories\CurrencyRepository;
use Illuminate\Http\Request;

class ApiDatabaseController extends ApiBaseController
{

    /**
     * Returns the positions list with price, total and share for portfolio with given id.
     *
     * @param Request $request
     * @return string
     */
    public function positions(Request $request)
    {
        $portfolio = $this->getPortfolio($request);

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
            $record['share'] = $record['total'] / $total;
        }

        return collect(['positions' => $positions, 'total' => $total]);
    }


    public function risk(Request $request)
    {
        $risk = $this->getPortfolio($request)->keyFigure('risk')->values;
        return collect(['risk' => $risk]);
    }


    public function value(Request $request)
    {
        $values = $this->getPortfolio($request)->keyFigure('value')->values;
        return collect(['values' => $values]);
    }


    public function contribution(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:portfolios,id',
            'date' => 'required|date',
            'conf' => 'required|numeric'
        ]);

        $contribution = $this->getPortfolio($request)->keyFigure('contribution')->values;
        return $contribution[$request->date][$request->conf];
    }

}
