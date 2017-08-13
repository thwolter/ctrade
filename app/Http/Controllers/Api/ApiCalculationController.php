<?php

namespace App\Http\Controllers\Api;


use App\Models\Rscript;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiCalculationController extends ApiBaseController
{

    /**
     * Calculate the risk for given portfolio.
     * e.g. api/portfolio/risk?id=1&date=2016-06-30&count=250
     *
     * @param Request $request
     * @return array
     */
    public function portfolioCalculateRisk(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:portfolios,id',
            'date' => 'required|date',
            'count' => 'required|numeric'
        ]);

        $date = Carbon::createFromFormat('Y-m-d', $request->date);

        $rscript = new Rscript($this->getPortfolio($request));
        $risk = $rscript->portfolioRisk($date, $request->count);
        return $risk;
    }


    /**
     * Calculate the value for given portfolio.
     * e.g. api/portfolio/value?id=1&date=2016-06-30
     *
     * @param Request $request
     * @return array
     */
    public function portfolioCalculateValue(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:portfolios,id',
            'date' => 'required|date'
        ]);

        $date = Carbon::createFromFormat('Y-m-d', $request->date);

        $rscript = new Rscript($this->getPortfolio($request));
        $value = $rscript->portfolioValue($date);

        return $value;
    }
}
