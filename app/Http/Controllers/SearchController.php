<?php

namespace App\Http\Controllers;

use App\Repositories\Yahoo\StockFinancial;
use App\Repositories\Yahoo\CurrencyFinancial;
use Illuminate\Http\Request;
use App\Entities\Portfolio;
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

        $portfolio = Portfolio::find($id);
        
        $stock = new StockFinancial;
        $currency = new CurrencyFinancial;

        return view('positions.create', [
            'portfolio' => $portfolio, 
            'stock' => $stock,
            'currency' => $currency,
            'symbol' => $symbol
        ]);


    }
 
}
