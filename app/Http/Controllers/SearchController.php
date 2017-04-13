<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Portfolio;
use DirkOlbrich\YahooFinanceQuery\YahooFinanceQuery;
use App\Http\Controllers\InstrumentController As Instrument;

class SearchController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param int $id - portfolio id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $query = new YahooFinanceQuery;

        $string = $request->get('search');
        $suggest =  $query->symbolSuggest($string)->get();

        return view ('search.index', compact('portfolio', 'suggest'));
    }

    
    /**
     * Display the specified resource.
     *
     * @param string $symbol
     * @param string $type
     * @return \Illuminate\Http\Response
     */
    public function show($symbol, $type)
    {
        Instrument::make($type)->show($symbol);
    }
 
}
