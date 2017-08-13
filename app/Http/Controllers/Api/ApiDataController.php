<?php

namespace App\Http\Controllers\Api;

use App\Repositories\CurrencyRepository;
use Illuminate\Http\Request;

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
        //Todo: get portfolio for a specified day in the past based on transactions analysis
        return collect($this->getPortfolio($request)->toArray());
    }
}
