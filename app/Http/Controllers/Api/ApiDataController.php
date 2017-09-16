<?php

namespace App\Http\Controllers\Api;

use App\Entities\Portfolio;
use App\Http\Resources\AssetHistories;
use App\Http\Resources\HistoryCollection;
use App\Http\Resources\PortfolioAssets;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiDataController extends ApiBaseController
{


    /**
     * Provides a collection of histories for the portfolio's risk factors.
     * Request requires the portfolio $id.
     *
     * @param Request $request
     * @return AssetHistories
     */
    public function histories(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:portfolios,id',
            'date' => 'required_without:from|date',
            'count' => 'required_with:date|integer',
            'from' => 'required_without:date|date',
            'to' => 'required_with:from|date'
        ]);

        return new AssetHistories(Portfolio::find($request->id));
    }

    /**
     * Provides the portfolio data including positions details.
     *
     * @param Request $request
     * @return PortfolioAssets
     */
    public function portfolio(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:portfolios,id',
            'date' => 'sometimes|date',
        ]);

        return new PortfolioAssets(Portfolio::find($request->id));
    }




}
