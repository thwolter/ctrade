<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::check())
            return redirect(route('portfolios.index'));
        else
            return view('home.home');

    }
}
