<?php

namespace App\Http\Controllers;

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
     * Show the form for creating a new resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //Todo: better use redirect
        return app(SearchController::class)->index(new Request(), $id);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id the portfolio id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'amount' => 'min:0'
        ]);

        $amount = $request->get('amount');
        $instrument = resolve($request->get('type'))->find($request->get('itemId'));

        $positionId = Portfolio::find($id)->makePosition($instrument);
        Portfolio::buy($positionId, $amount);

        return redirect(route('positions.index', $id));

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     *
     */
    public function show($id)
    {
        $position = Position::find($id);
        $portfolio = $position->portfolio;

        return view('positions.show', compact('portfolio', 'position'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id the position id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this -> validate(request(), [
            'amount' => 'min:0'
        ]);

        $amount = $request->get('amount');

        if ($request->get('direction') == 'buy') {
            $portfolio = Portfolio::buy($id, $amount);
        } else {
            $portfolio = Portfolio::sell($id, $amount);
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


    public function buy($id)
    {
        $position = Position::find($id);
        $portfolio = $position->portfolio;

        return view('positions.buy', compact('position', 'portfolio'));
    }


    public function sell($id)
    {
        $position = Position::find($id);
        $portfolio = $position->portfolio;

        return view('positions.sell', compact('position', 'portfolio'));
    }



}
