<?php

namespace App\Http\Controllers;

use App\Entities\Stock;
use App\Http\Requests\SearchRequest;
use Illuminate\Http\Request;
use App\Entities\Portfolio;

class SearchController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    protected $types = [
        'stock' => 'Aktie'
    ];

    protected $typesMap = [
        'stock' => Stock::class
    ];



    /**
     * Display the specified resource.
     *
     * @param int $id of the portfolio
     * @param Request $request
     * @param int $id the portfolio's id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $portfolio = Portfolio::find($id);
        $item = resolve($this->typesMap[$request->type])->find($request->id);

        return view('search.show', compact('portfolio', 'item'));
    }

    public function searchStock(SearchRequest $request)
    {
        return json_encode(Stock::search($request->get('query'))->get());
    }
}
