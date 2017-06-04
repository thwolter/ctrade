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
     * @return string
     */
    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'amount' => 'min:0'
        ]);

        $portfolio = Portfolio::find($id);

        $amount = $request->get('amount');
        $instrument = resolve($request->get('type'))->find($request->get('itemId'));

        if ($request->get('deduct') == 'yes') {
            $portfolio->buy($amount, $instrument);
        } else {
            $portfolio->obtain($amount, $instrument);
        }

        return redirect(route('positions.index', $portfolio->id));

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
        $position = Position::findOrFail($id);
        $portfolio = $position->portfolio;
        //$instrument = $position->positionable;

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $portfolio, $id)
    {
        $this -> validate(request(), [
            'amount' => 'required'
        ]);

        $position = Position::find($id);
        $position->update(['amount' => $request->get('amount')]);

        return redirect(route('positions.index', $position->portfolio->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $position = Position::find($id);
        $position->delete();

        return redirect(route('positions.index', $position->portfolio->id));
    }

}
