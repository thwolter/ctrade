<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Portfolio;
use App\Position;
use App\Stock;



class PositionsController extends Controller
{

    protected $stock;


    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $positions = $portfolio->positions;
        return view('positions.index', compact('portfolio', 'positions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        return view('search.create', compact('portfolio'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function store(Request $request)
    {
        $this -> validate(request(), [
            'symbol' => 'required'
        ]);

        $position = new Position;

        $portfolio = Portfolio::findOrFail($request->input('portfolio_id'));

        $stock = Stock::firstOrCreate([
            'symbol'=> $request->get('symbol'),
            'currency'=>$request->get('symbol') ]);

        $stock->positions()->save($position);
        $portfolio->positions()->save($position);

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
    public function update(Request $request, $id)
    {
        //
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
