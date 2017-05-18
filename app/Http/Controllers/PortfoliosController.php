<?php

/**
 * @purpose
 * 
 * Provides CRUD for 
 * portfolio with name and currency
 *  
 */

namespace App\Http\Controllers;

use App\Entities\Currency;
use Illuminate\Http\Request;
use App\Entities\Portfolio;
use App\Entities\User;

class PortfoliosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portfolios = User::findOrFail(auth()->id())->portfolios;
        return view('portfolios.index', compact('portfolios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('portfolios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this -> validate(request(), [
            'name' => 'required',
            'currency' => 'required',
            'cash' => 'required'
        ]);


        $portfolio = new Portfolio([
            'name' => $request->get('name'),
            'cash' => $request->get('cash'),
            'currency_id' => Currency::whereCode($request->get('currency'))->first()->id
        ]);

        auth()->user()->portfolios()->save($portfolio);

        return redirect(route('portfolios.show', $portfolio->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        return view('portfolios.show', compact('portfolio'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        return view('portfolios.edit', compact('portfolio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Portfolio::whereId($id)->update(['name' => $request->name, 'currency'=> $request->currency]);

        return redirect(route('portfolios.show', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Portfolio::whereId($id)->delete($id);

        return redirect(route('portfolios.index'));
    }


}

