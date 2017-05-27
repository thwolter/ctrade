<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! count(auth()->user()->portfolios))
        {
            return redirect()->route('portfolios.create');
        }

        $id = auth()->user()->first()->visited_portfolio_id;
        if (is_null($id))
            $id = auth()->user()->portfolios->first()->id;

        return redirect()->route('portfolios.show', ['id' => $id]);
    }
}
