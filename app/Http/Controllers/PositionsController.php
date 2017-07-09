<?php

namespace App\Http\Controllers;

use App\Entities\Transaction;
use App\Http\Requests\PositionStore;
use App\Repositories\FinancialMapping;
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        return view('positions.index', compact('portfolio'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id the portfolio id
     * @return array
     */
    public function store(PositionStore $request, $id)
    {
        $amount = $request->amount;
        $instrument = resolve($request->type)->find($request->id);

        $position = Portfolio::find($id)->makePosition($instrument);
        $portfolio = Portfolio::buy($position->id, $amount);

        Transaction::buy($portfolio, new \DateTime(), $position, $amount);

        return ['redirect' => route('positions.index', $id)];

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
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id the position id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $portfolioId, $positionId)
    {
        $amount = $request->amount;
        $position = Position::find($positionId);

        if ($request->get('direction') == 'buy') {

            $portfolio = Portfolio::buy($positionId, $amount);
            Transaction::buy($portfolio, new \DateTime(), $position, $amount);
        }
        else {

            $portfolio = Portfolio::sell($positionId, $amount);
            Transaction::sell($portfolio, new \DateTime(), $position, $amount);

        }

        return redirect(route('positions.index', $portfolio->id));
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
