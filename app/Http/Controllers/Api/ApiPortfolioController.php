<?php

namespace App\Http\Controllers\Api;

use App\Facades\Repositories\KeyfigureRepository;
use App\Facades\Repositories\PortfolioRepository;
use App\Http\Resources\AssetResource;
use App\Http\Resources\TimeSeriesResource;
use Illuminate\Http\Request;

class ApiPortfolioController extends ApiBaseController
{


    /**
     * Returns the positions list with price, total and share for portfolio with given id.
     *
     * @param Request $request
     * @return AssetResource
     */
    public function assets(Request $request)
    {
        $attributes = $request->validate([
            'id' => 'required|exists:portfolios,id'
        ]);

        $portfolio = PortfolioRepository::findPortfolioById($attributes['id']);

        return new AssetResource($portfolio);
    }


    /**
     * Returns the time series of risk for a given portfolio and confidence level from database.
     *
     * @param Request $request
     * @return TimeSeriesResource
     */
    public function risk(Request $request)
    {
        $attributes = $request->validate([
            'id' => 'required|exists:portfolios,id',
            'conf' => 'required|numeric'
        ]);

        $portfolio = PortfolioRepository::findPortfolioById($attributes['id']);
        $keyfigure = KeyfigureRepository::getByPortfolio($portfolio, 'risk.'.$attributes['conf']);

        return new TimeSeriesResource($keyfigure);
    }


    /**
     * Returns the historic values of a given portfolio from database.
     *
     * @param Request $request
     * @return TimeSeriesResource
     */
    public function value(Request $request)
    {
        $attributes = $request->validate([
            'id' => 'required|exists:portfolios,id',
            'conf' => 'required|numeric'
        ]);

        $portfolio = PortfolioRepository::findPortfolioById($attributes['id']);
        $keyfigure = KeyfigureRepository::getByPortfolio($portfolio, 'value');

        return new TimeSeriesResource($keyfigure);
    }


    /**
     * @param Request $request
     * @return TimeSeriesResource
     */
    public function contribution(Request $request)
    {
        $attributes = $request->validate([
            'id' => 'required|exists:portfolios,id',
            'date' => 'required|date',
            'conf' => 'required|numeric'
        ]);

        $portfolio = PortfolioRepository::findPortfolioById($attributes['id']);
        $keyfigure = KeyfigureRepository::getByPortfolio($portfolio, 'contribution.'.$attributes['conf']);

        return new TimeSeriesResource($keyfigure);
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

        return null;
    }


    public function keyFigures(Request $request)
    {
        $attributes = $request->validate([
            'id' => 'required|exists:portfolios,id',
            'date' => 'required|date',
            'conf' => 'required|numeric',
            'count' => 'required|numeric'
        ]);

        return null;
    }


}
