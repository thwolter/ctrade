<?php

namespace App\Http\Controllers;

use App\Entities\Stock;
use Illuminate\Http\Request;
use App\Entities\Portfolio;

class SearchController extends Controller
{

    protected $types = [
        Stock::class => 'Aktie'
    ];

    /**
     * Display the search field and list of suggested items
     * if a search string was delivered
     *
     * @param Request $request
     * @param int $id the portfolio id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $types = $this->types;

        if ($type = $request->get('type')) {
            $suggest = resolve($request->get('type'))
                ->search($request->get('search'))->get();
        }

        return view ('search.index', compact('portfolio', 'suggest', 'types'));
    }

    
    /**
     * Display the specified resource.
     *
     * @param int $id of the portfolio
     * @param string $type item's class name
     * @param int $itemId the item's id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $type, $itemId)
    {
        $portfolio = Portfolio::find($id);
        $item = resolve($type)->find($itemId);

        return view('search.show', compact('portfolio', 'item'));
    }
 
}
