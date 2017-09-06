<?php

namespace App\Http\Controllers;

use App\Entities\Datasource;
use App\Entities\Transaction;
use App\Http\Requests\PositionStore;
use App\Http\Requests\PositionUpdate;
use App\Repositories\FinancialMapping;
use App\Repositories\PositionRepository;
use Carbon\Carbon;
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
     * @param $slug
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $slug)
    {
        $portfolio = auth()->user()->portfolios()->whereSlug($slug)->first();
        return view('positions.index', array_merge(['portfolio' => $portfolio], $request->all()));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param PositionStore|Request $request
     * @return array
     */
    public function store(PositionStore $request)
    {
        $portfolio = Portfolio::find($request->pid);
        $instrument = resolve($request->type)->find($request->id);

        $position = $portfolio->makePosition($instrument, $request->datasourceId);

        $portfolio->buy($position->id, $request->amount);
        Transaction::buy($portfolio, Carbon::now(), $position, $request->amount);

        return ['redirect' => route('positions.index', $portfolio->slug)];

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     *
     */
    public function show($pid, $id)
    {
        $position = Position::find($id);
        $portfolio = $position->portfolio;

        return view('positions.show', compact('portfolio', 'position'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param PositionUpdate $request
     * @return array
     */
    public function update(PositionUpdate $request)
    {
        $amount = $request->amount;
        $id = $request->id;

        $position = Position::find($id);
        $portfolio = $position->portfolio;

        switch ($request->transaction) {
            case 'buy':
                $portfolio->buy($id, $amount);
                Transaction::buy($portfolio, Carbon::now(), $position, $amount);
                break;
            case 'sell':
                $portfolio->sell($id, $amount);
                Transaction::sell($portfolio, Carbon::now(), $position, $amount);
                break;
        }

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

    public function fetch(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        $position = Position::find($request->id);

        $item = $position->positionable->toArray();
        $price = $position->price();
        $amount = $position->amount;
        $cash = $position->portfolio->cash();

        return compact('item', 'price', 'amount', 'cash');

    }
}
