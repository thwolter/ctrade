<?php

namespace App\Http\Controllers\Api;

use App\Entities\Stock;
use App\Http\Requests\SearchRequest;
use App\Repositories\SearchRepository;
use Illuminate\Http\Request;

class ApiSearchController extends ApiBaseController
{

    protected $search;

    public function __construct(SearchRepository $search)
    {
        $this->search = $search;
    }

    /**
     * Receive search results from entities.
     *
     * @param SearchRequest $request
     * @return string
     */
    public function search(SearchRequest $request)
    {
        return json_encode($this->search
            ->search($request->get('entity'), $request->get('query'))
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
        return json_encode($this->search
            ->lookup($request->get('entity'), $request->get('id'))
        );
    }
}
