<?php


namespace App\Http\Controllers\Api;

use App\Entities\Portfolio;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiBaseController extends Controller
{

    /**
     * Returns the portfolio for a requested id.
     *
     * @param Request $request
     * @return Portfolio
     */
    protected function getPortfolio(Request $request)
    {
        $portfolio = Portfolio::findOrFail($request->get('id'));
        return $portfolio;
    }


    /**
     * Return all week days either within a period or as number up to set date.
     *
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    private function getWeekDaysSeries(Request $request): array
    {
        if (isset($request->date) && isset($request->count)) {
            $days = Helpers::allWeekDays($request->date, $request->count);
        } elseif (isset($request->from) && isset($request->to)) {
            $days = Helpers::allWeekDaysBetween($request->from, $request->to);
        } else {
            throw new \Exception("Parameter ['date' and 'count'] or ['from' and 'to'] must be set.");
        }

        return $days;
    }
}