<?php

namespace App\Http\Controllers\Api;

use App\Repositories\CurrencyRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\TradesRepository;

class ApiDataController extends ApiBaseController
{

    /**
     * Provides a collection of histories for the portfolio's risk factors.
     * Request requires the portfolio $id.
     *
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function histories(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:portfolios,id',
            'date' => 'required_without:from|date',
            'count' => 'required_with:date|integer',
            'from' => 'required_without:date|date',
            'to' => 'required_with:from|date'
        ]);


        $portfolio = $this->getPortfolio($request);
        $days = $this->getWeekDaysSeries($request);

        $result = [];
        foreach ($portfolio->positions as $position) {

            $key = $position->positionable_type . '_' . $position->positionable_id;
            $result[$key] = $position->history($days);

            $origin = $portfolio->currencyCode();
            $target = $position->currencyCode();

            if ($origin != $target)
                $result[$origin . $target] = (new CurrencyRepository($origin, $target))->history($days);
        }

        return collect($result);
    }

    /**
     * Provides the portfolio data including positions details.
     *
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function portfolio(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:portfolios,id',
            'date' => 'sometimes|date',
        ]);

        $tradesRepo = new TradesRepository($this->getPortfolio($request));
        $date = Carbon::parse($request->get('date', null));

        return collect($tradesRepo->rollbackToDate($date));
    }
}
