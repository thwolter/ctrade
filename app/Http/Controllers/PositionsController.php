<?php

namespace App\Http\Controllers;

use App\Facades\DataService;
use App\Http\Requests\TradeRequest;
use App\Repositories\DatasourceRepository;
use App\Services\PortfolioService;
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


    public function show(Portfolio $portfolio, $entity, $slug)
    {
        $instrument = resolve('App\\Entities\\'.ucfirst($entity));
        $stock = $instrument::findBySlug($slug);
        $prices = resolve(DatasourceRepository::class)->collectHistories($stock->datasources);

        $exchanges = $stock->exchangesToArray();
        $exchange = array_get($exchanges, '0.code');

        $repo = new DataService($stock->datasources()->whereExchange($exchange)->first());
        $history = array_add($repo->allDataHistory([]), 'currency', 'EUR');

        return view('positions.show_'.strtolower($entity),
            compact('portfolio', 'stock', 'prices', 'exchanges', 'history')
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param TradeRequest|Request $request
     * @return array
     */
    public function store(TradeRequest $request)
    {
        Portfolio::find($request->portfolioId)
            ->service()->storeTrade($request->all());

        return ['status' => 'success'];
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
