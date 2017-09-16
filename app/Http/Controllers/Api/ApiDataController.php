<?php

namespace App\Http\Controllers\Api;

use App\Entities\Portfolio;
use App\Http\Resources\AssetHistories;
use App\Http\Resources\HistoryCollection;
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
        $attributes = $request->validate([
            'id' => 'required|exists:portfolios,id',
            'date' => 'required_without:from|date',
            'count' => 'required_with:date|integer',
            'from' => 'required_without:date|date',
            'to' => 'required_with:from|date'
        ]);

        $result = $this->getPortfolio($request)->collectHistories($attributes);

        return new AssetHistories(Portfolio::find($request->id));
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




}
