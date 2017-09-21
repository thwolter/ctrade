<?php

namespace App\Http\Controllers\Api;

use App\Entities\LimitType;
use App\Entities\Portfolio;
use App\Repositories\CurrencyRepository;
use App\Repositories\LimitRepository;
use App\Repositories\PortfolioRepository;
use App\Repositories\RiskRepository;
use App\Repositories\StatisticsRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiPortfolioController extends ApiBaseController
{

    protected $statistic;

    public function __construct(StatisticsRepository $statistic)
    {
        $this->statistic = $statistic;
    }

    /**
     * Returns the positions list with price, total and share for portfolio with given id.
     *
     * @param Request $request
     * @return string
     */
    public function assets(Request $request)
    {
        $attributes = $request->validate([
            'id' => 'required|exists:portfolios,id'
        ]);

        return $this->statistic->getAssetsArray($attributes);
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
        $attributes = $request->validate([
            'id' => 'required|exists:portfolios,id',
            'conf' => 'required|numeric'
        ]);

        return $this->statistic->getRisks($attributes);
    }


    /**
     * Returns the historic values of a given portfolio from database.
     *
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function value(Request $request)
    {
        $attributes = $request->validate([
            'id' => 'required|exists:portfolios,id',
            'conf' => 'required|numeric'
        ]);

        return collect([
            'values' => $this->getPortfolio($request)->keyFigure('value')->values,
            'risk' => $this->statistic->getRisks($attributes)
        ]);
    }


    public function contribution(Request $request)
    {
        $attributes = $request->validate([
            'id' => 'required|exists:portfolios,id',
            'date' => 'required|date',
            'conf' => 'required|numeric'
        ]);

       return $this->statistic->getRiskContribution($attributes);
    }


    public function limits(Request $request)
    {
       //
    }


    public function utilisation(Request $request)
    {
        $attributes = $request->validate([
            'id' => 'required|exists:portfolios,id',
        ]);

        $this->statistic->getLimitUtilisation($attributes);
    }


    public function keyFigures(Request $request)
    {
        $attributes = $request->validate([
            'id' => 'required|exists:portfolios,id',
            'date' => 'required|date',
            'conf' => 'required|numeric',
            'count' => 'required|numeric'
        ]);

        return $this->statistic->getTimeSeries($attributes);
    }


}
