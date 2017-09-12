<?php

namespace App\Http\Controllers\Api;

use App\Facades\TimeSeries;
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
        foreach ($portfolio->assets()->get() as $asset) {

            $result[$asset->label()] = $asset->positionable->history($days);

            $origin = $portfolio->currencyCode();
            $target = $asset->currencyCode();

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

        $date = Carbon::parse($request->get('date', null));

        //return collect($tradesRepo->rollbackToDate($date));

        return $this->getPortfolio($request);
    }


    /**
     * Return all week days either within a period or as number up to set date.
     *
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function getWeekDaysSeries(Request $request)
    {
        if (isset($request->date) && isset($request->count)) {
            $days = TimeSeries::allWeekDays($request->date, $request->count);

        } elseif (isset($request->from) && isset($request->to)) {
            $days = TimeSeries::allWeekDaysBetween($request->from, $request->to);

        } else {
            throw new \Exception("Parameter ['date' and 'count'] or ['from' and 'to'] must be set.");
        }

        return $days;
    }

}
