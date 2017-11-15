<?php

namespace App\Http\Controllers\Api;

use App\Entities\Stock;
use App\Http\Requests\SearchRequest;
use App\Repositories\SearchRepository;
use Illuminate\Http\Request;

class ApiSearchController extends ApiBaseController
{

    /**
     * @var SearchRepository
     */
    protected $search;

    public function __construct(SearchRepository $search)
    {
        $this->search = $search;
    }


    /**
     * Receive search results from entities.
     *
     * @param Request $request
     * @return string
     */
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string'
        ]);

        return json_encode($this->search
            ->search(Stock::class, $request->get('query'))
        );
    }


    /**
     * receive metadata and price history for an stock with given id.
     *
     * @param Request $request
     * @return string
     */
    public function lookup(Request $request)
    {
        $request->validate([
            'instrumentType' => 'required|string',
            'instrumentId' => 'required|integer'
        ]);

        return json_encode($this->search
            ->lookup($request->get('instrumentType'), $request->get('instrumentId'))
        );
    }
}
