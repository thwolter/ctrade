<?php

namespace App\Http\Controllers;


use App\Entities\User;
use App\Http\Requests\SubscribeRequest;
use App\Jobs\Subscription\SendVerificationEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

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
            return redirect(route('portfolios.index'))->withSuccess(session('success'));
        else
            return redirect(route('home.launch'));
            //return view('home.home');
    }

    public function contact()
    {
        return view('home.contact');
    }

    public function about()
    {
        return view('home.about');
    }

    public function blog()
    {
        return redirect(config('links.blog', route('home.coming')));
    }

    public function coming()
    {
        return view('home.coming');
    }

    public function legal()
    {
        return view('home.legal');
    }

    public function launch()
    {
        return view('home.launch');
    }



}
