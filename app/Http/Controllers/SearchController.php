<?php

namespace App\Http\Controllers;

use App\Instrument;
use App\Repositories\FinancialRepository;
use Illuminate\Http\Request;
use App\Portfolio;
use DirkOlbrich\YahooFinanceQuery\YahooFinanceQuery;

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
    public function show($id, $type, $symbol) {

        //TODO based on instrument type chose correct model and blade

        $portfolio = Portfolio::find($id);

        $repo = FinancialRepository::make(mapToType($type),['symbol' => $symbol]);

        $blade = Instrument::blade('App\\'.mapToType($type));

        return view($blade, compact('portfolio', 'repo'));


    }
 
}
