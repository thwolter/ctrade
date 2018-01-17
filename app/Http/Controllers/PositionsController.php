<?php

namespace App\Http\Controllers;

use App\Http\Requests\TradeRequest;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use App\Entities\Portfolio;
use App\Entities\Position;


class PositionsController extends Controller
{

    protected $transaction;


    public function __construct(TransactionService $transaction)
    {
        $this->middleware('auth');

        $this->transaction = $transaction;
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Portfolio $portfolio
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Portfolio $portfolio)
    {
        return view('positions.index', array_merge(['portfolio' => $portfolio], $request->all()));
    }

    /**
     * Create a new resource based on given entity and instrument.
     *
     * @param Portfolio $portfolio
     * @return \Illuminate\Http\Response
     */
    public function search(Portfolio $portfolio)
    {
        return view('positions.search', compact('portfolio'));
    }


    public function show(Portfolio $portfolio, Request $request, $entity, $slug)
    {
        $stock = $this->getInstrument($entity, $slug);
        $exchange = $request->get('exchange', key($stock->firstExchange()));

        return view('positions.show_'.strtolower($entity),
            compact( 'portfolio', 'stock', 'exchange'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param TradeRequest|Request $request
     * @return array
     */
    public function store(TradeRequest $request)
    {
        $portfolio = Portfolio::find($request->portfolioId);
        $this->transaction->trade($portfolio, $request->all());

        return ['status' => 'success'];
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy($id)
    {
        $position = Position::find($id);
        $portfolio = $position->portfolio;

        $position->delete();

        return redirect(route('positions.index', $portfolio->id));
    }

    /**
     * @param $entity
     * @return mixed
     */
    private function getInstrument($entity, $slug)
    {
        $instrument = resolve('App\\Entities\\' . ucfirst($entity));
        return $instrument::findBySlug($slug);
    }
}
