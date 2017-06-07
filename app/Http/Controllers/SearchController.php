<?php

namespace App\Http\Controllers;

use App\Entities\Stock;
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
        $search = $request->search;

        if (array_key_exists($request->type, $this->types)) {

            $suggest = resolve(array_get($this->typesMap, $request->type))
                ->search($search)->get();
        }

        return view ('search.index',
            compact('portfolio', 'suggest', 'types', 'search'));
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
