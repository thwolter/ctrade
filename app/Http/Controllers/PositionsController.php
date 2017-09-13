<?php

namespace App\Http\Controllers;

use App\Entities\Stock;
use App\Http\Requests\TradeRequest;
use Illuminate\Http\Request;
use App\Entities\Portfolio;
use App\Entities\Position;



class PositionsController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param string $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $slug)
    {
        $portfolio = auth()->user()->portfolios()->whereSlug($slug)->first();
        return view('positions.index', array_merge(['portfolio' => $portfolio], $request->all()));
    }


    public function buyStock($portfolioSlug, $slug)
    {
        return view('positions.stocks.trade', [
            'portfolio' => Portfolio::whereSlug($portfolioSlug)->first(),
            'stock' => Stock::findBySlug($slug),
            'transaction' => 'buy'
        ]);
    }


    public function sellStock($portfolioSlug, $slug)
    {
        return view('positions.stocks.trade', [
            'portfolio' => Portfolio::whereSlug($portfolioSlug)->first(),
            'stock' => Stock::findBySlug($slug),
            'transaction' => 'sell'
        ]);
    }


    public function create($portfolioSlug, $entity, $slug)
    {
        $instrument = resolve('App\\Entities\\'.ucfirst($entity));

        return view('positions.'.str_plural($entity).'.trade', [
            'portfolio' => Portfolio::whereSlug($portfolioSlug)->first(),
            'stock' => $instrument::findBySlug($slug),
            'transaction' => 'buy'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TradeRequest|Request $request
     * @return array
     */
    public function store(TradeRequest $request)
    {
        $portfolio = Portfolio::find($request->portfolioId)->tradePosition($request->all());

        return ['redirect' => route('positions.index', $portfolio->slug)];
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $position = Position::find($id)->delete();

        return redirect(route('positions.index', $position->portfolio->id));
    }
}
