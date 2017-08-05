<?php

namespace App\Http\Controllers\Api;

use App\Entities\LimitType;
use App\Entities\Portfolio;
use App\Repositories\CurrencyRepository;
use App\Repositories\LimitRepository;
use App\Repositories\RiskRepository;
use Carbon\Carbon;
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


    /**
     * Returns the time series of risk for a given portfolio and confidence level
     * from database. Confidence levels can be 0.95, 0.975, or 0.99.
     *
     * @param Request $request
     * @return array
     */
    public function risk(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:portfolios,id',
            'conf' => 'required|numeric'
        ]);

        $values = $this->getPortfolio($request)->keyFigure('risk')->values;

        $result = [];
        for ($i = 0; $i < count($values); $i++) {
            $result[array_keys($values)[$i]] = array_get($values[array_keys($values)[$i]], $request->conf);
        }

        return $result;
    }


    /**
     * Returns the historic values of a given portfolio from database.
     *
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function value(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:portfolios,id',
        ]);

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

        return array_get(array_get($contribution, $request->date), $request->conf);
    }

    public function limits(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:portfolios,id',
            'date' => 'required|date',
            'count' => 'sometimes|required|numeric'
        ]);

        $limits = new LimitRepository($this->getPortfolio($request));
        return $limits->limitHistory($request->type, $request->date, $request->count);
    }

    public function utilisation(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:portfolios,id',
            'conf' => 'required|numeric',
            'period' => 'required|numeric',
            'reference' => 'required|date'
        ]);

        $portfolio = $this->getPortfolio($request);

        $limits = new LimitRepository($portfolio);
        $risks = new RiskRepository($portfolio, Carbon::parse($request->reference));

        $risk = $risks->portfolioRisk($request->conf, $request->period);

        $result = [];
        foreach ($portfolio->limits()->active()->get() as $type)
        {
            $limit = $limits->get($type->type->code)->value;
            $date = $limits->get($type->type->code)->date;

            switch($type->type->code) {
                case 'absolute':
                    $quota = $risk / $limit;
                    break;
                case 'relative':
                    $quota = $risk / ($limit * $portfolio->total() / 100);
                    break;
                case 'floor':
                    $quota = $risk / ($portfolio->total() - $limit);
                    break;
                case 'target':
                    $riskToTarget = $risks->portfolioRisk($request->conf, null, Carbon::parse($date));
                    $quota = $risk / ($portfolio->total() - $limit);
                    break;
                default:
                    $quota = null;
            }
            $result[$type->type->code] = [
                'quota' => $quota,
                'risk' => $risk,
                'limit' => $limit,
                'date' => $date,
                'ccy' => $portfolio->currencyCode()
            ];
        };

        return $result;
    }

    public function graph(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:portfolios,id',
            'date' => 'required|date',
            'conf' => 'required|numeric',
            'count' => 'required|numeric'
        ]);
        //todo: return both value and risk history
        $values = $this->getPortfolio($request)->keyFigure('value')->values;

        return $values;
    }
}
