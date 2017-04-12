<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Portfolio;
use DirkOlbrich\YahooFinanceQuery\YahooFinanceQuery;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Portfolio $portfolio)
    {
        $query = new YahooFinanceQuery;

        $string = $request->get('search');
        $suggest =  $query->symbolSuggest($string)->get();

        return view ('search.index', compact('portfolio', 'suggest'));
    }

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($symbol)
    {
        return view('search.show');
    }
 
}
