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

    public function contact()
    {
        return view('contact.contact');
    }

    public function about()
    {
        return view('contact.about');
    }

    public function blog()
    {
        return redirect(env('BLOG_URL', route('home.coming')));
    }

    public function coming()
    {
        return view('contact.coming');
    }

    public function legal()
    {
        return view('contact.legal');
    }
}
